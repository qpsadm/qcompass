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
        $agenda = Agenda::where('id', $id)
            ->where('is_show', 1)
            ->where('status', 'yes')
            ->firstOrFail();

        $categories = $this->getUserCategories(Auth::id());

        return view('user.agenda.agendas_info', compact('agenda', 'categories'));
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
}
