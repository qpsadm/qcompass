<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;

class UserDetailController extends Controller
{
    public function index()
    {
        $user_details = UserDetail::all();
        return view('user_details.index', compact('user_details'));
    }

    public function create()
    {
        return view('user_details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'birthday' => 'nullable',
            'gender' => 'nullable',
            'phone1' => 'nullable',
            'phone2' => 'nullable',
            'postal_code' => 'nullable',
            'address1' => 'nullable',
            'address2' => 'nullable',
            'emergency_contact' => 'nullable',
            'avatar_path' => 'nullable',
            'theme_color' => 'nullable',
            'status' => 'nullable',
            'is_show' => 'nullable',
            'divisions_id' => 'nullable',
            'bio' => 'nullable',
            'memo1' => 'nullable',
            'memo2' => 'nullable',
            'joining_date' => 'nullable',
            'leaving_date' => 'nullable',
            'leaving_reason' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        UserDetail::create($validated);
        return redirect()->route('user_details.index')->with('success', 'UserDetail作成完了');
    }

    public function show($id)
    {
        $UserDetail = UserDetail::findOrFail($id);
        return view('user_details.show', compact('UserDetail'));
    }

    public function edit($id)
    {
        $UserDetail = UserDetail::findOrFail($id);
        return view('user_details.edit', compact('UserDetail'));
    }

    public function update(Request $request, $id)
    {
        $UserDetail = UserDetail::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'nullable',
            'birthday' => 'nullable',
            'gender' => 'nullable',
            'phone1' => 'nullable',
            'phone2' => 'nullable',
            'postal_code' => 'nullable',
            'address1' => 'nullable',
            'address2' => 'nullable',
            'emergency_contact' => 'nullable',
            'avatar_path' => 'nullable',
            'theme_color' => 'nullable',
            'status' => 'nullable',
            'is_show' => 'nullable',
            'divisions_id' => 'nullable',
            'bio' => 'nullable',
            'memo1' => 'nullable',
            'memo2' => 'nullable',
            'joining_date' => 'nullable',
            'leaving_date' => 'nullable',
            'leaving_reason' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        $UserDetail->update($validated);
        return redirect()->route('user_details.index')->with('success', 'UserDetail更新完了');
    }

    public function destroy($id)
    {
        UserDetail::findOrFail($id)->delete();
        return redirect()->route('user_details.index')->with('success', 'UserDetail削除完了');
    }
}