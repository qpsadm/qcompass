<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organizer;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizer = Organizer::all();
        return view('admin.organizers.index', compact('organizer'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        Organizer::create($validated);
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer作成完了');
    }

    public function show($id)
    {
        $Organizer = Organizer::findOrFail($id);
        return view('admin.organizers.show', compact('Organizer'));
    }

    public function edit($id)
    {
        $Organizer = Organizer::findOrFail($id);
        return view('admin.organizers.edit', compact('Organizer'));
    }

    public function update(Request $request, $id)
    {
        $Organizer = Organizer::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        $Organizer->update($validated);
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer更新完了');
    }

    public function destroy($id)
    {
        Organizer::findOrFail($id)->delete();
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer削除完了');
    }
}
