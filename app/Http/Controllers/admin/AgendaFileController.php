<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaFile;

class AgendaFileController extends Controller
{
    public function index()
    {
        // 最新順で取得する例
        $agenda_files = \App\Models\AgendaFile::orderBy('created_at', 'desc')->get();

        // ビューに渡す
        return view('admin.agenda_files.index', compact('agenda_files'));
    }

    public function create()
    {
        // アジェンダ一覧を最新順で取得
        $agendas = \App\Models\Agenda::orderBy('created_at', 'desc')->get();

        // ビューに渡す
        return view('admin.agenda_files.create', compact('agendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'file_path' => 'required|file',
            'file_name' => 'required|string',
        ]);

        $file = $request->file('file_path');

        // 元の拡張子
        $extension = $file->getClientOriginalExtension();

        // ユーザー指定のファイル名 + 拡張子
        $filename = $request->file_name . '.' . $extension;

        // public ディスクに保存（storage/app/public/images
        $path = $file->storeAs('images', $filename, 'public');

        // DB登録
        $agendaFile = new \App\Models\AgendaFile();
        $agendaFile->agenda_id = $request->agenda_id;
        $agendaFile->file_path = $path;   // 保存パスをDBに保存
        $agendaFile->file_name = $filename;
        $agendaFile->file_type = $file->getMimeType();
        $agendaFile->file_size = $file->getSize();
        $agendaFile->description = $request->description;
        $agendaFile->save();

        return redirect()->route('admin.agenda_files.index')
            ->with('success', 'アジェンダファイルを保存しました。');
    }




    public function show($id)
    {
        $agendaFile = AgendaFile::with('agenda')->findOrFail($id);
        return view('admin.agenda_files.show', compact('agendaFile'));
    }

    public function edit($id)
    {
        $agendaFile = AgendaFile::findOrFail($id); // 小文字変数に統一
        $agendas = \App\Models\Agenda::orderBy('created_at', 'desc')->get();
        return view('admin.agenda_files.edit', compact('agendaFile', 'agendas'));
    }

    public function update(Request $request, $id)
    {
        $AgendaFile = AgendaFile::findOrFail($id);
        $validated = $request->validate([
            'agenda_id' => 'nullable',
            'file_path' => 'nullable',
            'file_name' => 'nullable',
            'file_type' => 'nullable',
            'description' => 'nullable',
            'file_size' => 'nullable',
            'user_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $AgendaFile->update($validated);
        return redirect()->route('admin.agenda_files.index')->with('success', 'AgendaFile更新完了');
    }

    public function destroy(AgendaFile $agendaFile)
    {
        $agendaFile->delete(); // モデルイベントでファイルも削除される
        return redirect()->route('admin.agenda_files.index')->with('success', 'ファイルを削除しました');
    }

    public function download($id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        // ファイルが存在するか確認
        if (!\Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        // ダウンロード
        return \Storage::disk('public')->download($agendaFile->file_path, $agendaFile->file_name);
    }
    public function preview($id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        if (!\Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        return response()->file(storage_path('app/public/' . $agendaFile->file_path));
    }
}
