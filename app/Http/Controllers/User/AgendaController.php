<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Agenda;

class AgendaController extends Controller
{
    /**
     * ユーザーがアクセス可能なカテゴリを取得
     */
    private function getUserCategories($userId)
    {
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        if (empty($userCourseIds)) {
            return collect();
        }

        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) {
            return collect();
        }

        return DB::table('categories')
            ->whereIn('id', $categoryIds)
            ->orderBy('sort', 'asc')
            ->get();
    }

    /**
     * 自分の講座アジェンダ一覧
     */
    public function myCourseAgendaList(Request $request)
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);
        $excludeCategoryIds = [52];

        // セッションにカテゴリ保存
        $categoryId = $request->input('category_id');
        session(['agenda_category_id' => $categoryId]);

        $search = $request->input('search');

        $query = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId && !in_array($categoryId, $excludeCategoryIds)) {
            $query->where('category_id', $categoryId)
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc');
        } else {
            // ALL の場合、一覧ページと同じカテゴリ順
            $userCourseIds = DB::table('course_users')->where('user_id', $userId)->pluck('course_id');
            $categoryIds = DB::table('course_categories')
                ->whereIn('course_id', $userCourseIds)
                ->pluck('category_id')
                ->diff($excludeCategoryIds)
                ->toArray();

            if (!empty($categoryIds)) {
                $orderSql = "CASE category_id ";
                foreach ($categoryIds as $index => $catId) {
                    $orderSql .= "WHEN {$catId} THEN {$index} ";
                }
                $orderSql .= "END";

                $query->orderByRaw($orderSql)
                    ->orderBy('created_at', 'desc')
                    ->orderBy('id', 'desc');
            }
        }

        if ($search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        $agendas = $query->paginate(5);

        $selectedCategoryName = 'All';
        if ($categoryId && !in_array($categoryId, $excludeCategoryIds)) {
            $selectedCategory = $categories->firstWhere('id', $categoryId);
            $selectedCategoryName = $selectedCategory ? $selectedCategory->name : 'All';
        }

        return view('user.agenda.agendas_list', [
            'agendas' => $agendas,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId,
            'selectedCategoryName' => $selectedCategoryName,
            'search' => $search,
        ]);
    }

    /**
     * アジェンダ詳細ページ
     */
    public function agendaDetail($id)
    {
        $userId = Auth::id();

        // 現在の記事
        $agenda = Agenda::where('id', $id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->firstOrFail();

        // ユーザーがアクセス可能なカテゴリ
        $userCategories = $this->getUserCategories($userId);

        // セッションからカテゴリID
        $categoryId = session('agenda_category_id');

        // 除外カテゴリ
        $excludeCategoryIds = [52];

        // 基本クエリ
        $baseQuery = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId) {
            // 選択カテゴリがある場合
            $baseQuery->where('category_id', $categoryId);
        } else {
            // ALLの場合はユーザーの講座カテゴリに絞る
            $userCourseIds = DB::table('course_users')
                ->where('user_id', $userId)
                ->pluck('course_id');

            $categoryIds = DB::table('course_categories')
                ->whereIn('course_id', $userCourseIds)
                ->where('is_show', 1)
                ->pluck('category_id')
                ->diff($excludeCategoryIds)
                ->toArray();
        }

        // 前後リンク用に全件取得
        $allAgendas = $baseQuery->get()->sortBy([
            // ALLの場合はカテゴリ順（sort順）
            fn($a, $b) => $categoryId ? 0 : array_search($a->category_id, $categoryIds) <=> array_search($b->category_id, $categoryIds),
            // 作成日降順
            fn($a, $b) => $b->created_at <=> $a->created_at,
            // ID降順
            fn($a, $b) => $b->id <=> $a->id,
        ])->values();

        $currentIndex = $allAgendas->search(fn($a) => $a->id === $agenda->id);

        $prevAgenda = $currentIndex > 0 ? $allAgendas[$currentIndex - 1] : null;
        $nextAgenda = $currentIndex < $allAgendas->count() - 1 ? $allAgendas[$currentIndex + 1] : null;

        return view('user.agenda.agendas_info', [
            'agenda' => $agenda,
            'categories' => $userCategories,
            'prevAgenda' => $prevAgenda,
            'nextAgenda' => $nextAgenda,
            'prevUrl' => $prevAgenda ? route('user.agenda.info', ['id' => $prevAgenda->id]) : null,
            'nextUrl' => $nextAgenda ? route('user.agenda.info', ['id' => $nextAgenda->id]) : null,
            'prevBtn' => (bool)$prevAgenda,
            'nextBtn' => (bool)$nextAgenda,
        ]);
    }




    /**
     * 前後記事取得ヘルパー
     */
    private function getPrevNext($baseQuery, $current)
    {
        $prev = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '<', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '<', $current->id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $next = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '>', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '>', $current->id);
                    });
            })
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        return [$prev, $next];
    }
}
