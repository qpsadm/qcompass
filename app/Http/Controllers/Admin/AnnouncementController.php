<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnnouncementType;
use App\Models\Course;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['type', 'course']);

        // 検索
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        // カテゴリー絞り込み
        if ($categoryId = $request->input('category_id')) {
            $query->where('type_id', $categoryId);
        }

        // 状態絞り込み
        if (!is_null($status = $request->input('status'))) {
            $query->where('status', $status);
        }

        // ソート
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        if (!in_array($sort, ['id', 'title', 'status'])) $sort = 'id';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'desc';

        $query->orderBy($sort, $direction);

        $announcements = $query->paginate(10)->withQueryString();
        $categories = AnnouncementType::all();
        $courses = Course::all();

        return view('admin.announcements.index', compact('announcements', 'categories', 'courses'));
    }

    public function create()
    {
        $announcement = new Announcement();
        $types = AnnouncementType::all();
        $courses = Course::all();

        return view('admin.announcements.create', compact('announcement', 'types', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:announcement_types,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'content' => 'nullable|string',
            'is_show' => 'required|boolean',
            'status' => 'required|integer',
        ]);

        $data['created_user_name'] = auth()->user()->name ?? 'system';

        // 分類が非表示ならお知らせも非表示
        $type = AnnouncementType::find($data['type_id']);
        if ($type && $type->is_show == 0) {
            $data['is_show'] = 0;
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを作成しました。');
    }

    public function edit(Announcement $announcement)
    {
        $types = AnnouncementType::all();
        $courses = Course::all();

        return view('admin.announcements.edit', compact('announcement', 'types', 'courses'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:announcement_types,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'content' => 'nullable|string',
            'is_show' => 'required|boolean',
            'status' => 'required|integer',
        ]);

        $data['updated_user_name'] = auth()->user()->name ?? 'system';

        $type = AnnouncementType::find($data['type_id']);
        if ($type && $type->is_show == 0) {
            $data['is_show'] = 0;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを更新しました。');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->deleted_user_name = auth()->user()->name ?? 'system';
        $announcement->save();
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを削除しました。');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }
}