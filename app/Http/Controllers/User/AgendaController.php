<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
    public function myCourseAgendaList()
    {
        $userId = Auth::id();
        Log::info("ユーザーID: {$userId}");

        // ユーザーが所属する講座ID
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();
        Log::info('所属講座ID: ' . implode(',', $userCourseIds));

        if (empty($userCourseIds)) {
            $categories = collect();
            $agendas = collect();
            return view('user.agenda.agendas_list', compact('categories', 'agendas'));
        }

        // 所属講座に紐づくカテゴリーID
        $categories = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
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
            ->get();

        // カテゴリーごとにまとめる
        $agendasByCategory = $agendas->groupBy('category_id');

        return view('user.agenda.agendas_list', compact('categories', 'agendasByCategory'));
    }
    public function agendaDetail($id)
    {
        $agenda = DB::table('agendas')->where('id', $id)->first();

        if (!$agenda) {
            abort(404, 'アジェンダが見つかりません');
        }

        return view('user.agenda.agendas_info', compact('agenda'));
    }
}
