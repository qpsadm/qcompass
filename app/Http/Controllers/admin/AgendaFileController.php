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
        $agenda_files = AgendaFile::where('target_type', Agenda::class)
            ->where('target_id', $agenda->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.agenda_files.agenda_index', compact('agenda', 'agenda_files'));
    }

    /**
     * お知らせ用ファイル一覧
     */
    public function announcementIndex(Announcement $announcement)
    {
        $announcement_files = AgendaFile::where('target_type', Announcement::class)
            ->where('target_id', $announcement->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.agenda_files.announcement_index', compact('announcement', 'announcement_files'));
    }

    /**
     * 作成フォーム（共通）
     */
    public function create($type, $id)
    {
        if ($type === 'agenda') {
            $target = Agenda::findOrFail($id);
        } elseif ($type === 'announcement') {
            $target = Announcement::findOrFail($id);
        } else {
            abort(404);
        }

        return view('admin.agenda_files.create', compact('target', 'type'));
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

        $route = $request->target_type === 'agenda' ? 'admin.agenda_files.agendaIndex' : 'admin.agenda_files.announcementIndex';

        return redirect()->route($route, $request->target_id)
            ->with('success', 'ファイルを保存しました。');
    }

    /**
     * 編集フォーム
     */
    // 編集フォーム
    public function edit($type, $id)
    {
        $file = AgendaFile::findOrFail($id);

        // typeごとの対象を取得（必要なら）
        if ($type === 'agenda') {
            $targets = \App\Models\Agenda::all();
        } elseif ($type === 'announcement') {
            $targets = \App\Models\Announcement::all();
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

        $route = $agendaFile->target_type === Agenda::class
            ? 'admin.agenda_files.agendaIndex'
            : 'admin.agenda_files.announcementIndex';

        return redirect()->route($route, $agendaFile->target_id)
            ->with('success', 'ファイルを更新しました。');
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        $agendaFile = AgendaFile::findOrFail($id);
        $targetId = $agendaFile->target_id;
        $targetType = $agendaFile->target_type;
        $agendaFile->delete();

        $route = $targetType === Agenda::class
            ? 'admin.agenda_files.agendaIndex'
            : 'admin.agenda_files.announcementIndex';

        return redirect()->route($route, $targetId)
            ->with('success', 'ファイルを削除しました。');
    }

    /**
     * プレビュー
     */
    // プレビュー
    public function preview($type, $id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        if (!Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        return response()->file(storage_path('app/public/' . $agendaFile->file_path));
    }
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