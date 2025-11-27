<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Agenda;

class CategoryController extends Controller
{
    public function index()
    {
        // ログイン中ユーザーが受講しているコースID
        $courseIds = DB::table('course_users')
            ->where('user_id', Auth::id())
            ->pluck('course_id');

        // 対象コースに紐づくカテゴリーID
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $courseIds)
            ->where('is_show', 1)
            ->pluck('category_id');

        // 親カテゴリーだけ取得（階層構造を保持）
        $categories = Category::whereIn('id', $categoryIds)
            ->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        // 各カテゴリーに紐づくアジェンダを取得
        $agendasByCategory = [];
        foreach ($categories as $category) {
            $agendasByCategory[$category->id] = Agenda::where('category_id', $category->id)
                ->where('is_show', 1)
                ->where('status', 'yes')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.agenda.agendas_list', compact('categories', 'agendasByCategory'));
    }
}
