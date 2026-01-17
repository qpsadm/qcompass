<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaFile;
use App\Models\Agenda;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AgendaFileController extends Controller
{
    public function index($type, $targetId = null)
    {
        if ($targetId) {
            $files = AgendaFile::where('target_type', $this->getTargetClass($type))
                ->where('target_id', $targetId)
                ->get();
        } else {
            // 全件表示
            $files = AgendaFile::where('target_type', $this->getTargetClass($type))->get();
        }

        return view('admin.files.index', compact('files', 'type', 'targetId'));
    }

    private function getTargetClass($type)
    {
        return $type === 'agenda' ? \App\Models\Agenda::class : \App\Models\Announcement::class;
    }

    public function create(string $type, $targetId = null)
    {
        $targets = match ($type) {
            'agenda' => Agenda::all(),
            'announcement' => Announcement::all(),
            default => abort(404),
        };

        $target = $targetId ? $targets->firstWhere('id', $targetId) : null;
        $returnUrl = request('return') ?? url()->previous();

        // 次のファイル番号取得
        $count = DB::table('files_counts')->value('count') ?? 0;
        $nextNumber = $count + 1;

        // Blade では拡張子はアップロード時に決まるので仮に空にしておく
        $defaultFileName = 'f' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.files.create', compact('type', 'targets', 'target', 'returnUrl', 'defaultFileName'));
    }

    public function store(Request $request, string $type, $targetId)
    {
        $validated = $request->validate([
            'target_id' => 'required|integer',
            'file_path' => 'required|file',
            'file_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:100',
            'return' => 'nullable|url',
        ]);

        $file = $request->file('file_path');

        // 拡張子取得
        $ext = $file->getClientOriginalExtension();

        // 次のファイル番号取得（念のため再取得して衝突防止）
        $count = DB::table('files_counts')->value('count') ?? 0;
        $nextNumber = $count + 1;

        // ファイル名生成
        $baseName = $validated['file_name']
            ? pathinfo($validated['file_name'], PATHINFO_FILENAME)
            : 'f' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $filename = $baseName . '.' . $ext;

        $targetClass = $type === 'agenda' ? Agenda::class : Announcement::class;
        $path = $file->storeAs('files', $filename, 'public');

        AgendaFile::create([
            'target_id'         => $validated['target_id'],
            'target_type'       => $targetClass,
            'file_path'         => $path,
            'file_name'         => $filename,
            'file_type'         => $file->getMimeType(),
            'file_size'         => $file->getSize(),
            'description'       => $validated['description'] ?? null,
            'created_user_name' => auth()->user()->name,
        ]);

        // files_counts インクリメント
        DB::table('files_counts')->updateOrInsert(
            ['id' => 1], // 1行だけ管理
            ['count' => DB::raw('count + 1')]
        );

        return redirect($validated['return'] ?? route("admin.{$type}s.edit", $validated['target_id']))
            ->with('success', 'ファイルを保存しました');
    }



    public function edit(string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        $targets = match ($type) {
            'agenda' => Agenda::all(),
            'announcement' => Announcement::all(),
            default => abort(404),
        };

        $returnUrl = request('return') ?? url()->previous();

        return view('admin.files.edit', compact('file', 'type', 'targets', 'returnUrl'));
    }

    public function update(Request $request, string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        $validated = $request->validate([
            'file_path'   => 'nullable|file',
            'file_name'   => 'required|string|max:255',
            'description' => 'nullable|string|max:100',
            'target_id'   => 'required|integer',
            'target_type' => 'required|in:agenda,announcement',
            'return_url'  => 'nullable|url',
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
        $file->target_type = $validated['target_type'] === 'agenda' ? Agenda::class : Announcement::class;
        $file->description = $validated['description'];
        $file->updated_user_name = auth()->user()->name;
        $file->save();

        return redirect($validated['return_url'] ?? url()->previous())
            ->with('success', 'ファイルを更新しました');
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect($request->return_url ?? url()->previous())
            ->with('success', 'ファイルを削除しました');
    }

    public function preview(string $type, int $id)
    {
        $file = AgendaFile::findOrFail($id);
        abort_unless(Storage::disk('public')->exists($file->file_path), 404);
        return response()->file(storage_path('app/public/' . $file->file_path));
    }
}
