<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementType;
use Illuminate\Http\Request;

class AnnouncementTypeController extends Controller
{
    public function index()
    {
        $types = AnnouncementType::orderBy('id', 'desc')->paginate(20);
        return view('admin.announcement_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.announcement_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['is_show'] = $request->has('is_show') ? 1 : 0; // チェックされていなければ0

        AnnouncementType::create($data);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', '作成しました');
    }

    public function edit($id)
    {
        $type = AnnouncementType::findOrFail($id);
        return view('admin.announcement_types.edit', compact('type'));
    }

    public function update(Request $request, AnnouncementType $type)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        // hidden input で必ず is_show が送信されるので has() でも大丈夫
        $type->update([
            'type_name' => $request->type_name,
            'is_show' => $request->has('is_show') ? 1 : 0,
        ]);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', '更新しました');
    }




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
