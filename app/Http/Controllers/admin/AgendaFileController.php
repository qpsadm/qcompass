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
     * アジェンダ用ファイル一覧
     */
    public function agendaIndex(Agenda $agenda)
    {
        // これは使わず共通 index に統一可能
        return redirect()->route('admin.files.index', ['type' => 'agenda', 'targetId' => $agenda->id]);
    }

    /**
     * お知らせ用ファイル一覧
     */
    public function announcementIndex(Announcement $announcement)
    {
        // 同様に共通 index に統一
        return redirect()->route('admin.files.index', ['type' => 'announcement', 'targetId' => $announcement->id]);
    }

    /**
     * 作成フォーム（共通）
     */
    public function create($type, $id = null)
    {
        if ($type === 'agenda') {
            $target = $id ? Agenda::find($id) : null;
            $targets = Agenda::all();
        } elseif ($type === 'announcement') {
            $target = $id ? Announcement::find($id) : null;
            $targets = Announcement::all();
        } else {
            abort(404);
        }

        return view('admin.files.create', compact('target', 'targets', 'type'));
    }

    /**
     * 保存（共通）
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_id' => 'required',
            'target_type' => 'required|in:agenda,announcement',
            'file_path' => 'required|file',
            'file_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file_path');
        $extension = $file->getClientOriginalExtension();
        $filename = $request->file_name . '.' . $extension;

        $path = $file->storeAs('images', $filename, 'public');

        $targetType = $request->target_type === 'agenda' ? Agenda::class : Announcement::class;

        $agendaFile = new AgendaFile();
        $agendaFile->target_id = $request->target_id;
        $agendaFile->target_type = $targetType;
        $agendaFile->file_path = $path;
        $agendaFile->file_name = $filename;
        $agendaFile->file_type = $file->getMimeType();
        $agendaFile->file_size = $file->getSize();
        $agendaFile->description = $request->description;
        $agendaFile->save();

        return redirect()->route('admin.files.index', [
            'type' => $request->target_type,
            'targetId' => $request->target_id
        ])->with('success', 'ファイルを保存しました。');
    }

    /**
     * 編集フォーム
     */
    public function edit($type, $id)
    {
        $file = AgendaFile::findOrFail($id);

        if ($type === 'agenda') {
            $targets = Agenda::all();
        } elseif ($type === 'announcement') {
            $targets = Announcement::all();
        } else {
            abort(404);
        }

        return view('admin.files.edit', compact('file', 'type', 'targets'));
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        $validated = $request->validate([
            'file_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $agendaFile->update($validated);

        return redirect()->route('admin.files.index', [
            'type' => $agendaFile->target_type === Agenda::class ? 'agenda' : 'announcement',
            'targetId' => $agendaFile->target_id
        ])->with('success', 'ファイルを更新しました。');
    }

    /**
     * 削除
     */
    public function destroy($type, $id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        // ファイルがストレージに存在する場合は削除
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($agendaFile->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($agendaFile->file_path);
        }

        $targetId = $agendaFile->target_id;
        $targetType = $agendaFile->target_type;

        // DBレコードを削除
        $agendaFile->delete();

        // リダイレクト先を判定
        $route = $targetType === \App\Models\Agenda::class
            ? 'admin.files.index'
            : 'admin.files.index';

        return redirect()->route($route, ['type' => $type, 'targetId' => $targetId])
            ->with('success', 'ファイルを削除しました。');
    }


    /**
     * プレビュー
     */
    public function preview($type, $id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        if (!Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        return response()->file(storage_path('app/public/' . $agendaFile->file_path));
    }

    /**
     * ファイル一覧（共通）
     */
    public function files($type, $targetId = 0)
    {
        if ($type === 'agenda') {
            $query = AgendaFile::where('target_type', Agenda::class);
        } elseif ($type === 'announcement') {
            $query = AgendaFile::where('target_type', Announcement::class);
        } else {
            abort(404);
        }

        if ($targetId != 0) {
            $query->where('target_id', $targetId);
        }

        $files = $query->orderBy('created_at', 'desc')->get();

        return view('admin.files.index', compact('files', 'type', 'targetId'));
    }
}