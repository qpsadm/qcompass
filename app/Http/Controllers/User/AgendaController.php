<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * 共通：ユーザーが閲覧可能なカテゴリ一覧を取得
     */
    private function getUserCategories($userId)
    {
        // 所属講座ID
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        if (empty($userCourseIds)) {
            return collect();
        }

        // カテゴリID
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) {
            return collect();
        }

        // カテゴリ一覧
        return DB::table('categories')
            ->whereIn('id', $categoryIds)
            ->orderBy('sort', 'asc')
            ->get();
    }

    /**
     * 自分の講座アジェンダ一覧
     */
    public function myCourseAgendaList()
    {
        $userId = Auth::id();

        // カテゴリ一覧（アコーディオン用）
        $categories = $this->getUserCategories($userId);

        if ($categories->isEmpty()) {
            return view('user.agenda.agendas_list', [
                'agendas' => collect(),
                'categories' => collect(),
            ]);
        }

        $categoryIds = $categories->pluck('id')->toArray();

        // 検索キーワード
        $search = request('search');

        if ($search) {
            $agendas = Agenda::search($search)
                ->get()
                ->where('status', 'yes')
                ->where('is_show', 1)
                ->whereIn('category_id', $categoryIds)
                ->sortByDesc('created_at');
        } else {
            $agendas = Agenda::whereIn('category_id', $categoryIds)
                ->where('status', 'yes')
                ->where('is_show', 1)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.agenda.agendas_list', compact('agendas', 'categories'));
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

        // アコーディオン用カテゴリ
        $categories = $this->getUserCategories(Auth::id());

        return view('user.agenda.agendas_info', compact('agenda', 'categories'));
    }

    /**
     * カテゴリー別アジェンダ一覧
     */
    public function agendaByCategory($category_id)
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);

        $agendas = Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.agenda.agendas_list', compact('agendas', 'categories'));
    }
}
