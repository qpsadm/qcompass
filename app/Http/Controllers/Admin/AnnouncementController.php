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
        $types = AnnouncementType::all();
        $courses = Course::all();

        return view('admin.announcements.create', compact('types', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|integer',
            'content'   => 'nullable|string',
            'course_id' => 'required|integer',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['created_user_name'] = auth()->user()->name ?? 'system';

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

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|integer',
            'content'   => 'nullable|string',
            'course_id' => 'required|integer',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['updated_user_name'] = auth()->user()->name ?? 'system';

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
}
