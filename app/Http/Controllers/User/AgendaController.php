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
        // ユーザーの講座IDを取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        if (empty($userCourseIds)) {
            return collect();
        }

        // 講座に紐づくカテゴリIDを取得
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        if (empty($categoryIds)) {
            return collect();
        }

        // カテゴリ情報を取得
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

        // 選択されたカテゴリ（GET/POSTどちらでもOK）
        $categoryId = $request->input('category_id');

        // セッションに保持
        session(['agenda_category_id' => $categoryId]);

        // 除外カテゴリリスト（必要なら）
        $excludeCategoryIds = [35];

        // アジェンダ取得クエリ
        $query = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId) {
            // 選択カテゴリがある場合
            $query->where('category_id', $categoryId);
        } else {
            // ALLの場合、自分の講座全カテゴリ
            $userCourseIds = DB::table('course_users')->where('user_id', $userId)->pluck('course_id');
            $categoryIds = DB::table('course_categories')
                ->whereIn('course_id', $userCourseIds)
                ->pluck('category_id');
            $query->whereIn('category_id', $categoryIds)
                ->whereNotIn('category_id', $excludeCategoryIds);
        }

        $agendas = $query->orderBy('created_at', 'desc')->paginate(5);

        $selectedCategoryName = 'All';
        if ($categoryId) {
            $selectedCategory = $categories->firstWhere('id', $categoryId);
            $selectedCategoryName = $selectedCategory ? $selectedCategory->name : 'All';
        }

        return view('user.agenda.agendas_list', [
            'agendas' => $agendas,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId,
            'selectedCategoryName' => $selectedCategoryName,
        ]);
    }

    /**
     * アジェンダ詳細ページ
     * セッションのカテゴリ選択をもとに前後移動
     */
    public function agendaDetail($id)
    {
        $userId = Auth::id();

        // 現在の記事を取得
        $agenda = Agenda::where('id', $id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->firstOrFail();

        // ユーザーがアクセス可能なカテゴリを取得
        $userCategories = $this->getUserCategories($userId);

        // セッションからカテゴリIDを取得
        $categoryId = session('agenda_category_id');

        // 除外カテゴリリスト
        $excludeCategoryIds = [35];

        // 前後記事取得用クエリ
        $baseQuery = Agenda::where('status', 'yes')
            ->where('is_show', 1)
            ->whereNotIn('category_id', $excludeCategoryIds);

        if ($categoryId) {
            // 選択カテゴリがある場合はそのカテゴリ内
            $baseQuery->where('category_id', $categoryId);
        } else {
            // ALLの場合、自分の講座全カテゴリ
            $userCourseIds = DB::table('course_users')->where('user_id', $userId)->pluck('course_id');
            $categoryIds = DB::table('course_categories')
                ->whereIn('course_id', $userCourseIds)
                ->pluck('category_id');
            $categoryIds = $categoryIds->diff($excludeCategoryIds); // 除外
            $baseQuery->whereIn('category_id', $categoryIds);
        }

        // 前後記事を取得
        [$prevAgenda, $nextAgenda] = $this->getPrevNext($baseQuery, $agenda);

        // URL生成
        $prevUrl = $prevAgenda ? route('user.agenda.info', ['id' => $prevAgenda->id]) : null;
        $nextUrl = $nextAgenda ? route('user.agenda.info', ['id' => $nextAgenda->id]) : null;

        return view('user.agenda.agendas_info', [
            'agenda' => $agenda,
            'categories' => $userCategories,
            'prevAgenda' => $prevAgenda,
            'nextAgenda' => $nextAgenda,
            'prevUrl' => $prevUrl,
            'nextUrl' => $nextUrl,
            'prevBtn' => (bool) $prevAgenda,
            'nextBtn' => (bool) $nextAgenda,
        ]);
    }

    /**
     * カテゴリでフィルターしたアジェンダ一覧
     */
    public function agendaByCategory($category_id)
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);

        // 選択カテゴリをセッションに保存
        session(['agenda_category_id' => $category_id]);

        $selectedCategory = $categories->firstWhere('id', $category_id);
        $selectedCategoryName = $selectedCategory ? $selectedCategory->name : null;

        $agendas = Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('user.agenda.agendas_list', compact(
            'agendas',
            'categories',
            'selectedCategoryName',
            'category_id'
        ));
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
