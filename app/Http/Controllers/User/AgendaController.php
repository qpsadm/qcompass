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

        // 所属講座IDを取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        if (empty($userCourseIds)) {
            $agendas = collect();
            return view('user.agenda.agendas_list', compact('agendas'));
        }

        // 所属講座のカテゴリーIDを取得
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) {
            $agendas = collect();
            return view('user.agenda.agendas_list', compact('agendas'));
        }

        // アジェンダを取得
        $agendas = DB::table('agendas')
            ->whereIn('category_id', $categoryIds)
            ->where('status', 'yes')    // 承認済み
            ->where('is_show', 1)       // 表示対象
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.agenda.agendas_list', compact('agendas'));
    }

    /**
     * 個別アジェンダ詳細
     */
    public function agendaDetail($id)
    {
        $agenda = DB::table('agendas')
            ->where('id', $id)
            ->where('is_show', 1)
            ->where('status', 'yes')
            ->first();

        if (!$agenda) {
            abort(404, 'アジェンダが見つかりません');
        }

        return view('user.agenda.agendas_info', compact('agenda'));
    }
}
