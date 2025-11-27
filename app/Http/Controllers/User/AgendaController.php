<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
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
            ->where('is_show', 1) // course_categories には存在
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) {
            $agendas = collect();
            return view('user.agenda.agendas_list', compact('agendas'));
        }

        // 検索キーワード
        $search = request('search');

        if ($search) {
            // Scout検索
            $agendas = Agenda::search($search)
                ->get() // Scoutの結果はコレクション
                ->where('status', 'yes')
                ->where('is_show', 1)
                ->whereIn('category_id', $categoryIds)
                ->sortByDesc('created_at');
            dd($agendas);
        } else {
            // 通常のクエリ
            $agendas = Agenda::whereIn('category_id', $categoryIds)
                ->where('status', 'yes')
                ->where('is_show', 1)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.agenda.agendas_list', compact('agendas'));
    }

    /**
     * 個別アジェンダ詳細
     */
    public function agendaDetail($id)
    {
        $agenda = Agenda::where('id', $id)
            ->where('is_show', 1)
            ->where('status', 'yes')
            ->firstOrFail();

        return view('user.agenda.agendas_info', compact('agenda'));
    }

    /**
     * カテゴリー別アジェンダ一覧
     */
    public function agendaByCategory($category_id)
    {
        $agendas = Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.agenda.agendas_list', compact('agendas'));
    }
}
