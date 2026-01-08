<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaFile;
use App\Models\Agenda;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AgendaFileController extends Controller
{
    /**
     * ファイル一覧
     */
    public function index(string $type, $targetId = null)
    {
        $query = AgendaFile::query();

        switch ($type) {
            case 'agenda':
                $query->where('target_type', Agenda::class);
                break;
            case 'announcement':
                $query->where('target_type', Announcement::class);
                break;
            case 'all':
                break;
            default:
                abort(404);
        }

        if ((int)$targetId > 0) {
            $query->where('target_id', $targetId);
        }

        $files = $query->orderByDesc('created_at')->get();

        return view('admin.files.index', compact('files', 'type', 'targetId'));
    }

    /**
     * 作成フォーム
     */
    public function create(string $type, $targetId = null)
    {
        $targets = match ($type) {
            'agenda' => Agenda::all(),
            'announcement' => Announcement::all(),
            default => abort(404),
        };

        $target = $targetId ? $targets->firstWhere('id', $targetId) : null;
        $returnUrl = request('return'); // ★ 戻り先

        return view('admin.files.create', compact(
            'type',
            'targets',
            'target',
            'returnUrl'
        ));
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_type' => 'required|in:agenda,announcement',
            'target_id'   => 'required|integer',
            'file_path'   => 'required|file',
            'file_name'   => 'required|string',
            'description' => 'nullable|string',
            'return_url'  => 'nullable|string',
        ]);

        $file = $request->file('file_path');
        $ext = $file->getClientOriginalExtension();
        $base = pathinfo($validated['file_name'], PATHINFO_FILENAME);
        $filename = $base . '.' . $ext;

        $path = $file->storeAs('files', $filename, 'public');

        AgendaFile::create([
            'target_id'   => $validated['target_id'],
            'target_type' => $validated['target_type'] === 'agenda'
                ? Agenda::class
                : Announcement::class,
            'file_path'   => $path,
            'file_name'   => $filename,
            'file_type'   => $file->getMimeType(),
            'file_size'   => $file->getSize(),
            'description' => $validated['description'],
        ]);

        // ★ 戻り先があれば最優先
        if ($request->filled('return_url')) {
            return redirect($request->return_url)
                ->with('success', 'ファイルを保存しました');
        }

        return redirect()->route('admin.files.index', [
            'type' => $validated['target_type'],
            'targetId' => $validated['target_id'],
        ])->with('success', 'ファイルを保存しました');
    }

    /**
     * 編集
     */
    public function edit(string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        $targets = match ($type) {
            'agenda' => Agenda::all(),
            'announcement' => Announcement::all(),
            default => abort(404),
        };

        $returnUrl = request('return');

        return view('admin.files.edit', compact(
            'file',
            'type',
            'targets',
            'returnUrl'
        ));
    }

    /**
     * 更新
     */
    public function update(Request $request, string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        $validated = $request->validate([
            'file_path'   => 'nullable|file',
            'file_name'   => 'required|string',
            'description' => 'nullable|string',
            'target_id'   => 'required|integer',
            'target_type' => 'required|in:agenda,announcement',
            'return_url'  => 'nullable|string',
        ]);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($file->file_path);

            $uploaded = $request->file('file_path');
            $ext = $uploaded->getClientOriginalExtension();
            $base = pathinfo($validated['file_name'], PATHINFO_FILENAME);
            $filename = $base . '.' . $ext;

            $file->file_path = $uploaded->storeAs('files', $filename, 'public');
            $file->file_name = $filename;
            $file->file_type = $uploaded->getMimeType();
            $file->file_size = $uploaded->getSize();
        } else {
            $ext = pathinfo($file->file_name, PATHINFO_EXTENSION);
            $base = pathinfo($validated['file_name'], PATHINFO_FILENAME);
            $file->file_name = $base . '.' . $ext;
        }

        $file->target_id   = $validated['target_id'];
        $file->target_type = $validated['target_type'] === 'agenda'
            ? Agenda::class
            : Announcement::class;
        $file->description = $validated['description'];
        $file->save();

        if ($request->filled('return_url')) {
            return redirect($request->return_url)
                ->with('success', 'ファイルを更新しました');
        }

        return redirect()->route('admin.files.index', [
            'type' => $validated['target_type'],
            'targetId' => $validated['target_id'],
        ])->with('success', 'ファイルを更新しました');
    }

    /**
     * 削除
     */
    public function destroy(Request $request, string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        Storage::disk('public')->delete($file->file_path);

        $targetId = $file->target_id;
        $redirectType = $file->target_type === Agenda::class
            ? 'agenda'
            : 'announcement';

        $file->delete();

        if ($request->filled('return_url')) {
            return redirect($request->return_url)
                ->with('success', 'ファイルを削除しました');
        }

        return redirect()->route('admin.files.index', [
            'type' => $redirectType,
            'targetId' => $targetId,
        ])->with('success', 'ファイルを削除しました');
    }

    /**
     * プレビュー
     */
    public function preview(string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        abort_unless(
            Storage::disk('public')->exists($file->file_path),
            404
        );

        return response()->file(
            storage_path('app/public/' . $file->file_path)
        );
    }
}
