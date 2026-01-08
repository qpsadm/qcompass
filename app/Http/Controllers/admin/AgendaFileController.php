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
    public function index(string $type, $targetId = null)
    {
        $query = AgendaFile::query();

        if ($type === 'agenda') $query->where('target_type', Agenda::class);
        elseif ($type === 'announcement') $query->where('target_type', Announcement::class);
        elseif ($type !== 'all') abort(404);

        if ($targetId) $query->where('target_id', $targetId);

        $files = $query->orderByDesc('created_at')->get();

        return view('admin.files.index', compact('files', 'type', 'targetId'));
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

        return view('admin.files.create', compact('type', 'targets', 'target', 'returnUrl'));
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
        $filename = $validated['file_name'] ?? $file->getClientOriginalName();
        $targetClass = $type === 'agenda' ? Agenda::class : Announcement::class;

        $path = $file->storeAs('files', $filename, 'public');

        AgendaFile::create([
            'target_id'        => $validated['target_id'],
            'target_type'      => $targetClass,
            'file_path'        => $path,
            'file_name'        => $filename,
            'file_type'        => $file->getMimeType(),
            'file_size'        => $file->getSize(),
            'description'      => $validated['description'] ?? null,
            'created_user_name' => auth()->user()->name,
        ]);

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
