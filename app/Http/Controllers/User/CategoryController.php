<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $courseIds)
            ->pluck('category_id');

        $categories = Category::whereIn('id', $categoryIds)
            ->with('children')
            ->get();

        return view('user.agenda.agendas_list', compact('categories'));
    }
}
