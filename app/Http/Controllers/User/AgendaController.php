<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

    public function myCourseAgendaList()
    {
        $userId = Auth::id();
        $categories = $this->getUserCategories($userId);
        $categoryIds = $categories->pluck('id')->toArray();

        $search = request('search');
        $selectedCategoryId = request('category_id');

        $query = Agenda::whereIn('category_id', $categoryIds)
            ->where('status', 'yes')
            ->where('is_show', 1);

        if ($search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        $agendas = $query->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends([
                'search' => $search,
                'category_id' => $selectedCategoryId,
            ]); // ページネーションでパラメータ保持

        $selectedCategoryName = $selectedCategoryId
            ? $categories->firstWhere('id', $selectedCategoryId)->name ?? null
            : null;

        return view('user.agenda.agendas_list', compact(
            'agendas',
            'categories',
            'selectedCategoryId',
            'selectedCategoryName',
            'search'
        ));
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
