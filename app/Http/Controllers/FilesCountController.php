<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilesCount;

class FilesCountController extends Controller
{
    public function index()
    {
        $files_count = FilesCount::all();
        return view('files_count.index', compact('files_count'));
    }

    public function create()
    {
        return view('files_count.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'count' => 'nullable',
        ]);
        FilesCount::create($validated);
        return redirect()->route('files_count.index')->with('success', 'FilesCount作成完了');
    }

    public function show($id)
    {
        $FilesCount = FilesCount::findOrFail($id);
        return view('files_count.show', compact('FilesCount'));
    }

    public function edit($id)
    {
        $FilesCount = FilesCount::findOrFail($id);
        return view('files_count.edit', compact('FilesCount'));
    }

    public function update(Request $request, $id)
    {
        $FilesCount = FilesCount::findOrFail($id);
        $validated = $request->validate([
            'count' => 'nullable',
        ]);
        $FilesCount->update($validated);
        return redirect()->route('files_count.index')->with('success', 'FilesCount更新完了');
    }

    public function destroy($id)
    {
        FilesCount::findOrFail($id)->delete();
        return redirect()->route('files_count.index')->with('success', 'FilesCount削除完了');
    }
}