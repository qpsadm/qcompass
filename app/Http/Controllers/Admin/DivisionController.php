<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::orderBy('id', 'desc')->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('admin.divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:divisions,code',
            'name' => 'required',
        ]);

        Division::create([
            ...$request->all(),
            'created_user_name' => auth()->user()->name ?? 'system',
        ]);

        return redirect()->route('admin.divisions.index')
            ->with('success', '部署を登録しました');
    }

    public function edit(Division $division)
    {
        return view('admin.divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'code' => 'required|unique:divisions,code,' . $division->id,
            'name' => 'required',
        ]);

        $division->update([
            ...$request->all(),
            'updated_user_name' => auth()->user()->name ?? 'system',
        ]);

        return redirect()->route('admin.divisions.index')
            ->with('success', '部署を更新しました');
    }

    public function destroy(Division $division)
    {
        $division->update([
            'deleted_user_name' => auth()->user()->name ?? 'system',
        ]);
        $division->delete();

        return redirect()->route('admin.divisions.index')
            ->with('success', '部署を削除しました');
    }
}
