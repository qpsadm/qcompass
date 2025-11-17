<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Agenda;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    // お知らせ一覧
    public function index()
    {
        $category = Category::firstOrCreate(
            ['code' => 'notice'],
            ['name' => 'お知らせ', 'is_show' => 1]
        );

        $agendas = Agenda::where('category_id', $category->id)
            ->with(['createdUser', 'courses'])
            ->get();

        return view('admin.notices.index', compact('category', 'agendas'));
    }

    // 作成フォーム
    public function create()
    {
        $category = Category::firstOrCreate(
            ['code' => 'notice'],
            ['name' => 'お知らせ', 'is_show' => 1]
        );

        $courses = Course::where('status', '1')->get();
        return view('admin.notices.create', compact('category', 'courses'));
    }

    // 保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
            'course_id' => 'required|array', // 複数選択
            'course_id.*' => 'exists:courses,id',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['category_id'] = Category::where('code', 'notice')->value('id');
        $validated['user_id'] = Auth::id();
        $validated['created_user_id'] = Auth::id();

        $agenda = Agenda::create($validated);

        // 講座の紐付け
        $agenda->courses()->sync($request->course_id);

        return redirect()->route('admin.notices.index')->with('success', 'お知らせを作成しました');
    }

    // 編集フォーム
    public function edit(Agenda $notice)
    {
        $courses = Course::where('is_show', 1)->get();
        return view('admin.notices.edit', [
            'agenda' => $notice,
            'courses' => $courses,
        ]);
    }

    // 更新
    public function update(Request $request, Agenda $notice)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
            'course_id' => 'required|array',
            'course_id.*' => 'exists:courses,id',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['updated_user_id'] = Auth::id();

        $notice->update($validated);

        $notice->courses()->sync($request->course_id);

        return redirect()->route('admin.notices.index')->with('success', 'お知らせを更新しました');
    }

    // 削除
    public function destroy(Agenda $notice)
    {
        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'お知らせを削除しました');
    }
}
