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
        $validated = $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'file_path' => 'required|file',
            'file_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000', // バリデーションはnullable
        ]);

        $file = $request->file('file_path');

        $path = $file->store('agenda_files');

        $agendaFile = new \App\Models\AgendaFile();
        $agendaFile->agenda_id   = $validated['agenda_id'];
        $agendaFile->file_path   = $path;
        $agendaFile->file_name   = $validated['file_name'];
        $agendaFile->file_type   = $file->getClientMimeType();
        $agendaFile->file_size   = round($file->getSize() / 1024, 2);
        $agendaFile->description = $validated['description'] ?? ''; // 空文字に変換
        $agendaFile->user_id     = auth()->id();
        $agendaFile->save();

        return redirect()->route('admin.agenda_files.index')->with('success', 'AgendaFile作成完了');
    }



    public function show($id)
    {
        $AgendaFile = AgendaFile::findOrFail($id);
        return view('admin.agenda_files.show', compact('AgendaFile'));
    }

    public function edit($id)
    {
        $AgendaFile = AgendaFile::findOrFail($id);
        return view('admin.agenda_files.edit', compact('AgendaFile'));
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

    public function destroy($id)
    {
        AgendaFile::findOrFail($id)->delete();
        return redirect()->route('admin.agenda_files.index')->with('success', 'AgendaFile削除完了');
    }
}