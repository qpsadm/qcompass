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

        // 🔍 検索
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orwhere('content', 'like', '%' . $request->search . '%');
        }

        // 🗂 カテゴリー
        if ($request->filled('category_id')) {
            $query->where('type_id', $request->category_id);
        }

        // 🎓 講座
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // 📌 ステータス絞り込み（安全版）
        $status = $request->input('status', null); // デフォルトは null
        if ($status !== null && $status !== '') {
            $query->where('status', (int)$status); // 文字列でも整数に変換して比較
        }

        $sort = $request->input('sort', 'updated_at');
        $direction = $request->input('direction', 'desc');

        // 🔃 ソート
        $allowedSorts = ['id', 'title', 'status', 'created_at', 'updated_at'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        $announcements = $query
            ->paginate(10)
            ->onEachSide(1)         //左にあるページネーションのボタン数を減らす
            ->appends($request->query());

        return view('admin.announcements.index', [
            'announcements' => $announcements,
            'categories'    => AnnouncementType::all(),
            'courses'       => Course::orderBy('id', 'desc')->get(), // 名前順
            'sort'          => $sort,
            'direction'     => $direction,
        ]);
    }

    public function create()
    {
        return view('admin.announcements.create', [
            'announcement' => new Announcement(),
            'types'        => AnnouncementType::all(),
            'courses'      => Course::orderBy('course_name', 'asc')->get(), // 名前順
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|exists:announcement_types,id',
            'course_id' => 'nullable|exists:courses,id',
            'content'   => 'nullable|string',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['created_user_name'] = auth()->user()->name ?? 'system';

        // 分類が非表示ならお知らせも非表示
        $type = AnnouncementType::find($data['type_id']);
        if ($type && !$type->is_show) {
            $data['is_show'] = 0;
        }

        Announcement::create($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'お知らせを作成しました。');
    }

    public function edit(Announcement $announcement)
    {
        $announcement->load(['files' => function ($q) {
            $q->withTrashed();
        }]);

        $types = AnnouncementType::all();
        $courses = Course::orderBy('course_name', 'asc')->get(); // 名前順
        // return view('admin.announcements.edit', [
        //     'announcement',
        //     'types'        => AnnouncementType::all(),
        //     'courses'      => Course::orderBy('course_name', 'asc')->get(), // 名前順
        // ]);

        return view(
            'admin.announcements.edit',
            compact(
                'announcement',
                'types',
                'courses'
            )
        );
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type_id'   => 'required|exists:announcement_types,id',
            'course_id' => 'nullable|exists:courses,id',
            'content'   => 'nullable|string',
            'is_show'   => 'required|boolean',
            'status'    => 'required|integer',
        ]);

        $data['updated_user_name'] = auth()->user()->name ?? 'system';

        $type = AnnouncementType::find($data['type_id']);
        if ($type && !$type->is_show) {
            $data['is_show'] = 0;
        }

        $announcement->update($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'お知らせを更新しました。');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->update([
            'deleted_user_name' => auth()->user()->name ?? 'system',
        ]);

        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'お知らせを削除しました。');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }
}
