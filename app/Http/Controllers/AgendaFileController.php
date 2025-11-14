<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaFile;

class AgendaFileController extends Controller
{
    public function index()
    {
        $agenda_files = AgendaFile::all();
        return view('agenda_files.index', compact('agenda_files'));
    }

    public function create()
    {
        return view('agenda_files.create');
    }

    public function store(Request $request)
    {
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
        AgendaFile::create($validated);
        return redirect()->route('agenda_files.index')->with('success', 'AgendaFile作成完了');
    }

    public function show($id)
    {
        $AgendaFile = AgendaFile::findOrFail($id);
        return view('agenda_files.show', compact('AgendaFile'));
    }

    public function edit($id)
    {
        $AgendaFile = AgendaFile::findOrFail($id);
        return view('agenda_files.edit', compact('AgendaFile'));
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
        return redirect()->route('agenda_files.index')->with('success', 'AgendaFile更新完了');
    }

    public function destroy($id)
    {
        AgendaFile::findOrFail($id)->delete();
        return redirect()->route('agenda_files.index')->with('success', 'AgendaFile削除完了');
    }
}