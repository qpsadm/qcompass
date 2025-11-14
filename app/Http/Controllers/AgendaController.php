<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all();
        return view('agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'is_show' => 'nullable',
            'user_id' => 'nullable',
            'accept' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        Agenda::create($validated);
        return redirect()->route('agendas.index')->with('success', 'Agenda作成完了');
    }

    public function show($id)
    {
        $Agenda = Agenda::findOrFail($id);
        return view('agendas.show', compact('Agenda'));
    }

    public function edit($id)
    {
        $Agenda = Agenda::findOrFail($id);
        return view('agendas.edit', compact('Agenda'));
    }

    public function update(Request $request, $id)
    {
        $Agenda = Agenda::findOrFail($id);
        $validated = $request->validate([
            'agenda_name' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'is_show' => 'nullable',
            'user_id' => 'nullable',
            'accept' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        $Agenda->update($validated);
        return redirect()->route('agendas.index')->with('success', 'Agenda更新完了');
    }

    public function destroy($id)
    {
        Agenda::findOrFail($id)->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda削除完了');
    }
}