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
        $excludeCategoryIds = [52, 53];

        // セッションにカテゴリ保存
        $categoryId = $request->input('category_id');
        session(['agenda_category_id' => $categoryId]);

        $search = $request->input('search');

        $query = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId && !in_array($categoryId, $excludeCategoryIds)) {
            // 選択カテゴリあり
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

        $agenda = Agenda::where('id', $id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->firstOrFail();

        $userCategories = $this->getUserCategories($userId);
        $categoryId = session('agenda_category_id');
        $excludeCategoryIds = [52, 53];

        // 基本クエリ
        $baseQuery = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId) {
            // 選択カテゴリがある場合
            $baseQuery->where('category_id', $categoryId);
            $categoryIds = null; // ALLじゃないので不要
        } else {
            // ALL の場合、ユーザーの講座カテゴリ順
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

        // 全件取得して一覧順に並び替え
        $allAgendas = $baseQuery->get()->sortBy([
            fn($a, $b) => $categoryIds ? array_search($a->category_id, $categoryIds) <=> array_search($b->category_id, $categoryIds) : 0,
            fn($a, $b) => $b->created_at <=> $a->created_at,
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
     * カテゴリ指定でアジェンダをページネート取得
     */
    public function getAgendasDataByCategoryPaginate($categoryId, $perPage = 5)
    {
        return Agenda::where('category_id', $categoryId)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function jobDlInfo($id)
    {
        $agenda = Agenda::findOrFail($id);

        // カテゴリ52以外は通常ページにリダイレクト
        if ($agenda->category_id != 52) {
            return redirect()->route('user.agenda.info', $agenda->id);
        }

        // 前後のアジェンダ取得（任意）
        $prevAgenda = Agenda::where('id', '<', $agenda->id)
            ->where('category_id', 52)
            ->orderBy('id', 'desc')
            ->first();
        $nextAgenda = Agenda::where('id', '>', $agenda->id)
            ->where('category_id', 52)
            ->orderBy('id')
            ->first();

        return view('user.job.job_dl_info', compact('agenda', 'prevAgenda', 'nextAgenda'));
    }


    public function download($id)
    {
        $agenda = Agenda::findOrFail($id);

        // セキュリティ：カテゴリ53以外は弾く
        if ($agenda->category_id != 53) {
            abort(404);
        }

        return view('user.download', compact('agenda'));
    }
}
