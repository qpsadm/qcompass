<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementType;
use Illuminate\Http\Request;

class AnnouncementTypeController extends Controller
{
    // 一覧
    public function index()
    {
        $types = AnnouncementType::orderBy('id', 'desc')->paginate(5);
        return view('admin.announcement_types.index', compact('types'));
    }

    // 作成フォーム
    public function create()
    {
        return view('admin.announcement_types.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        AnnouncementType::create([
            'type_name' => $request->type_name,
            'is_show' => $request->input('is_show', 0) ? 1 : 0, // チェックされていなければ0
            'created_user_name' => auth()->user()->name ?? 'system',
        ]);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', '作成しました');
    }

    // 編集フォーム
    public function edit($id)
    {
        $type = AnnouncementType::findOrFail($id);
        return view('admin.announcement_types.edit', compact('type'));
    }

    // 更新処理
    // 更新処理
    public function update(Request $request, $id)
    {
        $type = AnnouncementType::findOrFail($id);

        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        // 新しい表示フラグ
        $isShow = $request->input('is_show', 0) ? 1 : 0;

        $type->update([
            'type_name' => $request->type_name,
            'is_show' => $isShow,
            'updated_user_name' => auth()->user()->name ?? 'system',
        ]);

        // 🔹ここで紐づくお知らせも連動して更新
        $type->announcements()->update(['is_show' => $isShow]);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', '更新しました');
    }

    // 削除
    public function destroy($id)
    {
        $type = AnnouncementType::findOrFail($id);

        $type->deleted_user_name = auth()->user()->name ?? 'system';
        $type->save();
        $type->delete();

        return redirect()->route('admin.announcement_types.index')
            ->with('success', 'お知らせ分類を削除しました。');
    }
}
