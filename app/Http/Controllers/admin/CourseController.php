<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Organizer; //開催者
use App\Models\Level; // Levels テーブルのモデル
use App\Models\CourseType;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('search');

        $courses = Course::query();

        if ($query) {
            $courses = $courses->where(function ($q) use ($query) {
                $q->where('course_code', 'like', "%{$query}%")       // 講座コード
                    ->orWhere('course_name', 'like', "%{$query}%")    // 講座名
                    ->orWhereHas('organizer', function ($q2) use ($query) { // 主催者名
                        $q2->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('courseType', function ($q3) use ($query) { // 分野名
                        $q3->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('level', function ($q4) use ($query) { // 種類名
                        $q4->where('name', 'like', "%{$query}%");
                    });
            });
        }

        $courses = $courses->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }



    public function create()
    {
        $organizers = Organizer::all(); // 主催者取得
        $levels = Level::all(); // 講座種類（難易度）
        $courseTypes = CourseType::all();
        return view('admin.courses.create', compact('organizers', 'levels', 'courseTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'nullable',
            'course_type_ID' => 'nullable',
            'Level_id' => 'nullable',
            'organizer_id' => 'nullable|exists:organizers,id',
            'course_name' => 'nullable',
            'venue' => 'nullable',
            'application_date' => 'nullable',
            'certification_date' => 'nullable',
            'certification_number' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_hours' => 'nullable',
            'periods' => 'nullable',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable',
            'finish_viewing' => 'nullable',
            'plan_path' => 'nullable',
            'flier_path' => 'nullable',
            'capacity' => 'nullable',
            'entering' => 'nullable',
            'completed' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'category_ids' => 'array',
            'category_ids.*' => 'integer',
        ]);

        $validated['created_user_name'] = auth()->user()->name ?? 'system';
        $validated['status'] = isset($validated['status']) ? (int)$validated['status'] : 0;

        // 講座作成
        $course = Course::create($validated);

        // 🔥 中間テーブルへ登録
        if ($request->has('category_ids')) {
            $syncData = [];

            foreach ($request->category_ids as $catId) {
                $syncData[$catId] = [
                    'is_show' => 1,
                    'created_user_name' => Auth::user()->name,
                ];
            }

            $course->categories()->sync($syncData);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course作成完了');
    }



    public function show($id)
    {
        $Course = Course::findOrFail($id);
        return view('admin.courses.show', compact('Course'));
    }

    public function edit($id)
    {
        $Course = Course::findOrFail($id);

        // セレクト用データ取得
        $courseTypes = \App\Models\CourseType::all();
        $levels = \App\Models\Level::all();
        $organizers = \App\Models\Organizer::all();

        return view('admin.courses.edit', compact('Course', 'courseTypes', 'levels', 'organizers'));
    }
    public function update(Request $request, $id)
    {
        $Course = Course::findOrFail($id);

        $validated = $request->validate([
            'course_code' => 'nullable',
            'course_type_ID' => 'nullable',
            'Level_id' => 'nullable',
            'organizer_id' => 'nullable|exists:organizers,id',
            'course_name' => 'nullable',
            'venue' => 'nullable',
            'application_date' => 'nullable',
            'certification_date' => 'nullable',
            'certification_number' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_hours' => 'nullable',
            'periods' => 'nullable',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable',
            'finish_viewing' => 'nullable',
            'plan_path' => 'nullable',
            'flier_path' => 'nullable',
            'capacity' => 'nullable',
            'entering' => 'nullable',
            'completed' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'category_ids' => 'array',
            'category_ids.*' => 'integer',
        ]);

        $validated['updated_user_name'] = Auth::id();

        $Course->update($validated);

        // 🔥 中間テーブルを更新（sync）
        $syncData = [];
        if ($request->has('category_ids')) {
            foreach ($request->category_ids as $catId) {
                $syncData[$catId] = [
                    'is_show' => 1,
                    'updated_user_name' => Auth::user()->name,
                ];
            }
        }

        $Course->categories()->sync($syncData);

        return redirect()->route('admin.courses.index')->with('success', 'Course更新完了');
    }


    public function destroy($id)
    {
        $Course = Course::findOrFail($id);

        $Course->deleted_user_name = Auth::id();
        $Course->save();

        $Course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course削除完了');
    }
    public function getTeachers($courseId)
    {
        $course = Course::with('teachers')->findOrFail($courseId);

        // JSON形式で返す
        return response()->json($course->teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'name' => $teacher->name,
            ];
        }));
    }

    public function students(Course $course, Request $request)
    {
        $typeId = $request->query('type');

        // pivot 経由でユーザー取得、soft delete 無視
        $studentsQuery = $course->users()
            ->where('role_id', 3) // 3 = 生徒のみ
            ->wherePivotNull('deleted_at'); // pivot の削除フラグを考慮

        // 講座種別で絞り込み
        if ($typeId) {
            $studentsQuery->whereHas('courses', function ($q) use ($typeId) {
                $q->where('course_type_id', $typeId)
                    ->wherePivotNull('deleted_at'); // pivot の削除も考慮
            });
        }

        $students = $studentsQuery->paginate(20);

        // 担当講師も pivot の削除考慮して取得
        $teachers = $course->teachers()
            ->wherePivotNull('deleted_at')
            ->get();

        return view('admin.courses.students', compact('course', 'students', 'teachers'));
    }
}
