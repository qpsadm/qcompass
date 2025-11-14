<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaTag;

class AgendaTagController extends Controller
{
    public function index()
    {
        $agenda_tag = AgendaTag::all();
        return view('agenda_tag.index', compact('agenda_tag'));
    }

    public function create()
    {
        return view('agenda_tag.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        AgendaTag::create($validated);
        return redirect()->route('agenda_tag.index')->with('success', 'AgendaTag作成完了');
    }

    public function show($id)
    {
        $AgendaTag = AgendaTag::findOrFail($id);
        return view('agenda_tag.show', compact('AgendaTag'));
    }

    public function edit($id)
    {
        $AgendaTag = AgendaTag::findOrFail($id);
        return view('agenda_tag.edit', compact('AgendaTag'));
    }

    public function update(Request $request, $id)
    {
        $AgendaTag = AgendaTag::findOrFail($id);
        $validated = $request->validate([
            'agenda_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $AgendaTag->update($validated);
        return redirect()->route('agenda_tag.index')->with('success', 'AgendaTag更新完了');
    }

    public function destroy($id)
    {
        AgendaTag::findOrFail($id)->delete();
        return redirect()->route('agenda_tag.index')->with('success', 'AgendaTag削除完了');
    }
}