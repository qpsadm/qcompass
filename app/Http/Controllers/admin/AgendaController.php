<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Mews\Purifier\Facades\Purifier; // ← これを追加

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all();
        foreach ($agendas as $agenda) {
            $agenda->description_sanitized = Purifier::clean($agenda->description);
        }
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }
    public function show($id)
    {
        $agenda = Agenda::find($id);

        if (!$agenda) {
            abort(404);
        }

        return view('admin.agendas.show', [
            'Agenda' => $agenda, // ← ここでビューに渡す変数名を $Agenda にする
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
            'user_id' => 'nullable|integer',
        ]);

        // CKEditorのHTMLを安全化
        if (isset($validated['description'])) {
            $validated['description'] = Purifier::clean($validated['description']);
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを作成しました。');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.agendas.edit', compact('agenda')); // 小文字
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
            'user_id' => 'nullable|integer',
        ]);

        if (isset($validated['description'])) {
            $validated['description'] = Purifier::clean($validated['description']);
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを更新しました。');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました。');
    }
}
