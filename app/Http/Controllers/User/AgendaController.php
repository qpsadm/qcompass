<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
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

    public function myCourseAgendaList(Request $request)
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);

        // 除外したいカテゴリーIDを指定
        $excludeCategoryIds = [35];

        // 除外リストに入っているカテゴリは categories から除外
        $categories = $categories->reject(function ($category) use ($excludeCategoryIds) {
            return in_array($category->id, $excludeCategoryIds);
        });

        $categoryId = $request->input('category_id'); // 選択されたカテゴリ
        $search = $request->input('search');

        $query = Agenda::query()
            ->where('status', 'yes')
            ->where('is_show', 1);

        // 選択されたカテゴリーが除外リストなら無視
        if ($categoryId && !in_array($categoryId, $excludeCategoryIds)) {
            $query->where('category_id', $categoryId);
        }

        // 検索条件
        if ($search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        // 除外カテゴリーをクエリにも反映
        if (!empty($excludeCategoryIds)) {
            $query->whereNotIn('category_id', $excludeCategoryIds);
        }

        $agendas = $query->orderBy('created_at', 'desc')->paginate(5);

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




    public function agendaDetail($id)
    {
        $userId = Auth::id();

        // 記事そのものはステータスと表示設定だけで取得する
        $agenda = Agenda::where('id', $id)
            ->where('is_show', 1)
            ->where('status', 'yes')
            ->firstOrFail();

        // ユーザーが閲覧可能なカテゴリ
        $userCategories = $this->getUserCategories($userId);
        $userCategoryIds = $userCategories->pluck('id')->toArray();

        // 空の場合は記事のカテゴリを使う
        if (empty($userCategoryIds)) {
            $userCategoryIds = [$agenda->category_id];
        }

        // prev/next 用ベースクエリ
        $baseQuery = Agenda::where('is_show', 1)
            ->where('status', 'yes')
            ->where('category_id', $agenda->category_id)
            ->whereIn('category_id', $userCategoryIds)
            ->where('category_id', '!=', 35);

        // prev/next を取得
        [$prevAgenda, $nextAgenda] = $this->getPrevNext($baseQuery, $agenda);

        // prevUrl と nextUrl が null でない場合にのみURLを生成
        $prevUrl = $prevAgenda ? route('user.agenda.info', ['id' => $prevAgenda->id]) : null;
        $nextUrl = $nextAgenda ? route('user.agenda.info', ['id' => $nextAgenda->id]) : null;



        return view('user.agenda.agendas_info', [
            'agenda'     => $agenda,
            'categories' => $userCategories,
            'prevAgenda' => $prevAgenda,
            'nextAgenda' => $nextAgenda,
            'prevUrl'    => $prevUrl,
            'nextUrl'    => $nextUrl,
            'prevBtn'    => (bool) $prevAgenda,
            'nextBtn'    => (bool) $nextAgenda,
        ]);
    }



    public function agendaByCategory($category_id)
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);

        // 選択したカテゴリ名とID
        $selectedCategory = $categories->firstWhere('id', $category_id);
        $selectedCategoryName = $selectedCategory ? $selectedCategory->name : null;
        $selectedCategoryId   = $selectedCategory ? $selectedCategory->id : null;

        $agendas = Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('user.agenda.agendas_list', compact(
            'agendas',
            'categories',
            'selectedCategoryName',
            'selectedCategoryId'
        ));
    }


    public function getAgendasDataByCategory(int $category_id)
    {
        return Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * 新規追加：ページネーション対応
     */
    public function getAgendasDataByCategoryPaginate(int $category_id, int $perPage = 5)
    {
        return Agenda::where('category_id', $category_id)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }


    private function getPrevNext($baseQuery, $current)
    {
        // Prev（現在より古い記事を取得）
        $prev = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '<', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '<', $current->id);
                    });
            })
            // 🚨 修正: 最も近い「Prev」記事を取得するため、作成日時を降順、IDも降順にする
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first(); // 1件目を取得

        // Next（現在より新しい記事を取得）
        $next = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '>', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '>', $current->id);
                    });
            })
            // 🚨 修正: 最も近い「Next」記事を取得するため、作成日時を昇順、IDも昇順にする
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->first(); // 1件目を取得

        return [$prev, $next];
    }
}