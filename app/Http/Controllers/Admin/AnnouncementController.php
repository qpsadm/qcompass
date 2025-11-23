<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementType;
use App\Models\Course;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['type', 'course'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $courses = Course::all();
        $types = AnnouncementType::all();

        // 新規作成用に空の Announcement オブジェクトを渡す
        $announcement = new Announcement();

        return view('admin.announcements.create', compact('announcement', 'courses', 'types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|integer|exists:announcement_types,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'content'   => 'nullable|string',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['created_user_name'] = auth()->user()->name ?? 'system';

        // 選択された分類が非表示なら、お知らせも非表示に
        $type = AnnouncementType::find($data['type_id']);
        if ($type && $type->is_show == 0) {
            $data['is_show'] = 0;
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを作成しました。');
    }


    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        $types = AnnouncementType::all();
        $courses = Course::all();

        return view('admin.announcements.edit', compact('announcement', 'types', 'courses'));
    }
    public function update(Request $request, Announcement $announcement)
    {
        if ($request->input('course_id') == 0) {
            $request->merge(['course_id' => null]);
        }

        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|integer|exists:announcement_types,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'content'   => 'nullable|string',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['updated_user_name'] = auth()->user()->name ?? 'システム管理者';

        // 選択された分類が非表示なら、お知らせも非表示に
        $type = AnnouncementType::find($data['type_id']);
        if ($type && $type->is_show == 0) {
            $data['is_show'] = 0;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを更新しました。');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->deleted_user_name = auth()->user()->name ?? 'system';
        $announcement->save();
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを削除しました。');
    }
    public function show($id)
    {
        $announcement = Announcement::with(['type', 'course'])->findOrFail($id);
        return view('admin.announcements.show', compact('announcement'));
    }
}
