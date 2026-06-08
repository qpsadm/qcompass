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
     * @param int $userId
     * @param int|null $courseId
     */
    private function getUserCategories(int $userId, ?int $courseId = null)
    {
        $userCourseIds = $courseId
            ? [$courseId]
            : DB::table('course_users')->where('user_id', $userId)->pluck('course_id')->toArray();

        if (empty($userCourseIds)) return collect();

        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) return collect();

        return DB::table('categories')
            ->whereIn('id', $categoryIds)
            ->orderBy('code', 'asc')
            ->get();
    }

    /**
     * 自分の講座アジェンダ一覧
     */
    public function myCourseAgendaList(Request $request)
    {
        $isImpersonating = session()->has('impersonator_id');
        $userId = $isImpersonating ? session('impersonator_id') : Auth::id();
        $courseId = $isImpersonating
            ? session('impersonator_course_id')
            : session('course_id'); // 通常ユーザーの現在講座IDも優先

        // 排除処理を無くした。　福島　2026-06-08
        $excludeCategoryIds = [];

        // ユーザーがアクセス可能なカテゴリID
        $accessibleCategoryIds = DB::table('course_categories')
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->when(!$courseId, fn($q) => $q->whereIn('course_id', DB::table('course_users')->where('user_id', $userId)->pluck('course_id')))
            ->where('is_show', 1)
            ->pluck('category_id')
            ->diff($excludeCategoryIds)
            ->toArray();

        // カテゴリ一覧
        $categories = $this->getUserCategories($userId, $courseId)
            ->map(function ($category) use ($excludeCategoryIds) {
                $category->agenda_count = Agenda::where('category_id', $category->id)
                    ->where('status', 'yes')
                    ->where('is_show', 1)
                    ->whereNotIn('category_id', $excludeCategoryIds)
                    ->count();
                return $category;
            });

        $categoryId = $request->input('category_id');
        session(['agenda_category_id' => $categoryId]);

        $search = $request->input('search');

        // ✅ 基本クエリ
        $query = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereIn('category_id', $accessibleCategoryIds);

        // カテゴリ指定
        if ($categoryId && in_array($categoryId, $accessibleCategoryIds)) {
            $query->where('category_id', $categoryId);
        }

        // 検索
        if ($search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        // 並び順
        if (!empty($accessibleCategoryIds)) {
            $orderSql = "CASE category_id ";
            foreach ($accessibleCategoryIds as $index => $catId) {
                $orderSql .= "WHEN {$catId} THEN {$index} ";
            }
            $orderSql .= "END";

            $query->orderBy('updated_at', 'desc') // まず更新日降順
                ->orderByRaw($orderSql)         // 次にカテゴリ順
                ->orderBy('id', 'desc');        // 最後にID降順
        } else {
            // カテゴリが空でも更新日→ID降順でソート
            $query->orderBy('updated_at', 'desc')
                ->orderBy('id', 'desc');
        }

        $agendas = $query->paginate(5)->withQueryString();

        $selectedCategoryName = 'All';
        if ($categoryId && in_array($categoryId, $accessibleCategoryIds)) {
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
    public function agendaDetail(Agenda $agenda)
    {
        $isImpersonating = session()->has('impersonator_id');
        $userId = $isImpersonating ? session('impersonator_id') : Auth::id();
        $courseId = $isImpersonating
            ? session('impersonator_course_id')
            : session('course_id');

        $excludeCategoryIds = [52, 53];

        // ユーザーがアクセス可能なカテゴリID
        $accessibleCategoryIds = DB::table('course_categories')
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->when(!$courseId, fn($q) => $q->whereIn('course_id', DB::table('course_users')->where('user_id', $userId)->pluck('course_id')))
            ->where('is_show', 1)
            ->pluck('category_id')
            ->diff($excludeCategoryIds)
            ->toArray();

        $userCategories = $this->getUserCategories($userId, $courseId);
        $categoryId = session('agenda_category_id');

        // 基本クエリ
        $baseQuery = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereIn('category_id', $accessibleCategoryIds);

        if ($categoryId && in_array($categoryId, $accessibleCategoryIds)) {
            $baseQuery->where('category_id', $categoryId);
            $categoryIds = null;
        } else {
            $categoryIds = $accessibleCategoryIds;
        }

        // 全アジェンダ取得してコレクションでソート
        $allAgendas = $baseQuery->get()->sortBy([
            // 1. 更新日降順
            fn($a, $b) => $b->updated_at <=> $a->updated_at,
            // 2. カテゴリ順（アクセス可能順）
            fn($a, $b) => $categoryIds ? array_search($a->category_id, $categoryIds) <=> array_search($b->category_id, $categoryIds) : 0,
            // 3. ID降順
            fn($a, $b) => $b->id <=> $a->id,
        ])->values();

        // 現在表示中のアジェンダのインデックス
        $currentIndex = $allAgendas->search(fn($a) => $a->id === $agenda->id);
        $prevAgenda = $currentIndex > 0 ? $allAgendas[$currentIndex - 1] : null;
        $nextAgenda = $currentIndex < $allAgendas->count() - 1 ? $allAgendas[$currentIndex + 1] : null;

        return view('user.agenda.agendas_info', [
            'agenda' => $agenda,
            'categories' => $userCategories,
            'prevAgenda' => $prevAgenda,
            'nextAgenda' => $nextAgenda,
            'prevUrl' => $prevAgenda ? route('user.agenda.info', $prevAgenda) : null,
            'nextUrl' => $nextAgenda ? route('user.agenda.info', $nextAgenda) : null,
            'prevBtn' => (bool)$prevAgenda,
            'nextBtn' => (bool)$nextAgenda,
            'breadcrumbTitle' => $agenda->agenda_name,
        ]);
    }


    /**
     * カテゴリ指定でアジェンダをページネート取得
     */
    public function getAgendasDataByCategoryPaginate($categoryId, $perPage = 5)
    {
        return Agenda::where('category_id', $categoryId)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    public function jobDlInfo(Agenda $agenda)
    {
        if ($agenda->category_id != 52) {
            return redirect()->route('user.agenda.info', $agenda);
        }

        $prevAgenda = Agenda::where('id', '<', $agenda->id)
            ->where('category_id', 52)
            ->orderBy('id', 'desc')
            ->first();

        $nextAgenda = Agenda::where('id', '>', $agenda->id)
            ->where('category_id', 52)
            ->orderBy('id')
            ->first();

        return view('user.job.job_dl_info', compact(
            'agenda',
            'prevAgenda',
            'nextAgenda'
        ));
    }

    public function download(Agenda $agenda)
    {
        if ($agenda->category_id != 53) abort(404);
        return view('user.download', compact('agenda'));
    }
}