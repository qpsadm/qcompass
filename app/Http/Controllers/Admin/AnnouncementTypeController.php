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
        $data = $request->validate([
            'type_name' => 'required|string|max:255',
            'is_show'   => 'required|boolean',
        ]);

        $data['created_user_name'] = auth()->user()->name ?? 'system';

        AnnouncementType::create($data);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', 'お知らせ分類を作成しました。');
    }

    public function edit($id)
    {
        $type = AnnouncementType::findOrFail($id);
        return view('admin.announcement_types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = AnnouncementType::findOrFail($id);

        $data = $request->validate([
            'type_name' => 'required|string|max:255',
            'is_show'   => 'required|boolean',
        ]);

        $data['updated_user_name'] = auth()->user()->name ?? 'system';

        $type->update($data);

        return redirect()->route('admin.announcement_types.index')
            ->with('success', 'お知らせ分類を更新しました。');
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
