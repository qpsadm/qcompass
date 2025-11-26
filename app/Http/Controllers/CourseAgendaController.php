<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAgenda;

class CourseAgendaController extends Controller
{
    public function index()
    {
        $course_agendas = CourseAgenda::all();
        return view('course_agendas.index', compact('course_agendas'));
    }

    public function create()
    {
        return view('course_agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable',
            'target_id' => 'nullable',
            'order_no' => 'nullable',
            'note' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        CourseAgenda::create($validated);
        return redirect()->route('course_agendas.index')->with('success', 'CourseAgenda作成完了');
    }

    public function show($id)
    {
        $CourseAgenda = CourseAgenda::findOrFail($id);
        return view('course_agendas.show', compact('CourseAgenda'));
    }

    public function edit($id)
    {
        $CourseAgenda = CourseAgenda::findOrFail($id);
        return view('course_agendas.edit', compact('CourseAgenda'));
    }

    public function update(Request $request, $id)
    {
        $CourseAgenda = CourseAgenda::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'nullable',
            'target_id' => 'nullable',
            'order_no' => 'nullable',
            'note' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $CourseAgenda->update($validated);
        return redirect()->route('course_agendas.index')->with('success', 'CourseAgenda更新完了');
    }

    public function destroy($id)
    {
        CourseAgenda::findOrFail($id)->delete();
        return redirect()->route('course_agendas.index')->with('success', 'CourseAgenda削除完了');
    }
}
