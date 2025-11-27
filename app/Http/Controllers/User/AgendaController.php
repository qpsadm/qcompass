<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * 自分の講座アジェンダ一覧（カテゴリー別）
     */
    public function myCourseAgendaList()
    {
        $userId = Auth::id();

        // 所属講座ID取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        if (empty($userCourseIds)) {
            $agendasByCategory = collect();
            return view('user.agenda.agendas_list', compact('agendasByCategory'));
        }

        // 所属講座に紐づくカテゴリーID
        // $categories = DB::table('course_categories')
        //     ->whereIn('course_id', $userCourseIds)
        //     ->where('is_show', 1)
        //     ->get();

        // チャッピーによる変更
        $categories = DB::table('categories')
            ->whereIn('id', $userCourseIds)
            ->get();
        Log::info('取得カテゴリーID: ' . implode(',', $categories->pluck('category_id')->toArray()));





        // course_categories 経由でアジェンダ取得
        $agendas = DB::table('agendas as a')
            ->join('course_categories as cc', 'a.category_id', '=', 'cc.category_id')
            ->whereIn('cc.course_id', $userCourseIds)
            ->where('a.is_show', 1)
            ->where('a.status', 'yes')   // DBの値に合わせて
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'cc.course_id')

        // 所属講座のカテゴリーIDを取得
        // $categoryIds = DB::table('course_categories')
        //     ->whereIn('course_id', $userCourseIds)
        //     ->where('is_show', 1)
        //     ->pluck('category_id')
        //     ->toArray();

        // if (empty($categoryIds)) {
        //     $agendasByCategory = collect();
        //     return view('user.agenda.agendas_list', compact('agendasByCategory'));
        // }

        // アジェンダを取得
        // $agendas = DB::table('agendas')
        //     ->whereIn('course_id', $userCourseIds)
        //     ->whereIn('category_id', $categoryIds)
        //     ->where('status', 2)    // 承認済み
        //     ->where('is_show', 1)   // 表示対象
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // // カテゴリーごとにまとめる
        // $agendasByCategory = $agendas->groupBy('category_id');

        return view('user.agenda.agendas_list', compact('agendasByCategory'));
    }
}