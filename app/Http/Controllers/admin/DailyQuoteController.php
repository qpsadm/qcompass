<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyQuote;

class DailyQuoteController extends Controller
{
    private function checkCrudPermission()
    {
        $roleId = auth()->user()->role_id;

        // role 1～3: 管理画面不可は middleware で弾かれる想定

        // role 4: 閲覧のみ
        if ($roleId == 4) {
            $editableRoutes = ['create', 'store', 'edit', 'update', 'destroy'];
            foreach ($editableRoutes as $route) {
                if (\Route::currentRouteAction() && str_contains(\Route::currentRouteAction(), $route)) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        // role 5: 制限付き編集可
        if ($roleId == 5) {
            $allowed = ['questions', 'reports', 'course_teacher', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return; // OK
                }
            }
            abort(403, 'アクセス権限がありません。');
        }

        // role 6: 一部制限あり（必要ならここで制御）

        // role 7,8: フル CRUD → ここでは特にチェック不要
    }

    
    public function index()
    {
        $daily_quotes = DailyQuote::all();
        return view('admin.daily_quotes.index', compact('daily_quotes'));
    }

    public function create()
    {
        return view('admin.daily_quotes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote' => 'nullable',
            'author' => 'nullable',
            'display_date' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        DailyQuote::create($validated);
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote作成完了');
    }

    public function show($id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        return view('admin.daily_quotes.show', compact('DailyQuote'));
    }

    public function edit($id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        return view('admin.daily_quotes.edit', compact('DailyQuote'));
    }

    public function update(Request $request, $id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        $validated = $request->validate([
            'quote' => 'nullable',
            'author' => 'nullable',
            'display_date' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $DailyQuote->update($validated);
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote更新完了');
    }

    public function destroy($id)
    {
        DailyQuote::findOrFail($id)->delete();
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote削除完了');
    }
}
