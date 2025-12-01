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
        $categoryId = $request->input('category_id'); // nullの場合はAll
        $search = $request->input('search');

        $query = Agenda::query()->where('status', 'yes')->where('is_show', 1);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        $agendas = $query->orderBy('created_at', 'desc')->paginate(5);

        // 選択されたカテゴリー名を取得
        $selectedCategoryName = null;
        if ($categoryId) {
            $selectedCategory = $categories->firstWhere('id', $categoryId);
            if ($selectedCategory) {
                $selectedCategoryName = $selectedCategory->name;
            } else {
                $selectedCategoryName = 'All'; // 存在しないIDならAll扱い
            }
        } else {
            $selectedCategoryName = 'All';
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
