<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaFile;
use App\Models\Agenda;
use Illuminate\Support\Facades\Storage;

class AgendaFileController extends Controller
{
    /**
     * ファイル一覧
     */
    public function index()
    {
        $agenda_files = AgendaFile::with('target')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.agenda_files.index', compact('agenda_files'));
    }

    /**
     * ファイル作成フォーム
     */
    public function create()
    {
        $agendas = Agenda::orderBy('created_at', 'desc')->get();
        return view('admin.agenda_files.create', compact('agendas'));
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_id' => 'required|exists:agendas,id',
            'file_path' => 'required|file',
            'file_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file_path');
        $extension = $file->getClientOriginalExtension();
        $filename = $request->file_name . '.' . $extension;

        // storage/app/public/images に保存
        $path = $file->storeAs('images', $filename, 'public');

        $agendaFile = new AgendaFile();
        $agendaFile->target_id = $request->target_id;
        $agendaFile->target_type = Agenda::class; // polymorphic
        $agendaFile->file_path = $path;
        $agendaFile->file_name = $filename;
        $agendaFile->file_type = $file->getMimeType();
        $agendaFile->file_size = $file->getSize();
        $agendaFile->description = $request->description;
        $agendaFile->save();

        return redirect()->route('admin.agenda_files.index')
            ->with('success', 'ファイルを保存しました。');
    }

    /**
     * ファイル詳細
     */
    public function show($id)
    {
        $agendaFile = AgendaFile::with('target')->findOrFail($id);
        return view('admin.agenda_files.show', compact('agendaFile'));
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $agendaFile = AgendaFile::with('target')->findOrFail($id);
        $agendas = Agenda::orderBy('created_at', 'desc')->get();
        return view('admin.agenda_files.edit', compact('agendaFile', 'agendas'));
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        $validated = $request->validate([
            'target_id' => 'required|exists:agendas,id',
            'file_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $agendaFile->update($validated);

        return redirect()->route('admin.agenda_files.index')
            ->with('success', 'ファイルを更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(AgendaFile $agendaFile)
    {
        $agendaFile->delete(); // モデルイベントでファイルも削除される
        return redirect()->route('admin.agenda_files.index')
            ->with('success', 'ファイルを削除しました。');
    }

    /**
     * ダウンロード
     */
    public function download($id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        if (!Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        return Storage::disk('public')->download($agendaFile->file_path, $agendaFile->file_name);
    }

    /**
     * プレビュー
     */
    public function preview($id)
    {
        $agendaFile = AgendaFile::findOrFail($id);

        if (!Storage::disk('public')->exists($agendaFile->file_path)) {
            abort(404, 'ファイルが存在しません');
        }

        return response()->file(storage_path('app/public/' . $agendaFile->file_path));
    }
}