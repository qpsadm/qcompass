<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Organizer;
use App\Models\Level;
use App\Models\CourseType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $courses = Course::query();

        if ($query) {
            $courses = $courses->where(function ($q) use ($query) {
                $q->where('course_code', 'like', "%{$query}%")
                    ->orWhere('course_name', 'like', "%{$query}%")
                    ->orWhereHas('organizer', fn($q2) => $q2->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('courseType', fn($q3) => $q3->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('level', fn($q4) => $q4->where('name', 'like', "%{$query}%"));
            });
        }

        $courses = $courses->paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create', [
            'organizers' => Organizer::all(),
            'levels'     => Level::all(),
            'courseTypes' => CourseType::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'course_type_id' => 'required|exists:course_types,id',
            'level_id' => 'nullable|exists:levels,id',
            'organizer_id' => 'nullable|exists:organizers,id',
            'course_name' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'application_date' => 'nullable|date',
            'certification_date' => 'nullable|date',
            'certification_number' => 'nullable|string|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_hours' => 'nullable|integer',
            'periods' => 'nullable|integer',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable|date',
            'finish_viewing' => 'nullable|date',
            'plan_path' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls',
            'flier_path' => 'nullable|file|mimes:pdf,jpg,png,webp',
            'capacity' => 'nullable|integer',
            'entering' => 'nullable|integer',
            'completed' => 'nullable|integer',
            'description' => 'nullable|string',
            'mail_address' => 'nullable|email',
            'cc_address' => 'nullable|string',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'category_ids' => 'array',
            'category_ids.*' => 'integer',
        ]);

        if ($request->hasFile('plan_path')) {
            $validated['plan_path'] = $request->file('plan_path')->store('plans', 'public');
        }
        if ($request->hasFile('flier_path')) {
            $validated['flier_path'] = $request->file('flier_path')->store('fliers', 'public');
        }

        $validated['level_id'] = $validated['level_id'] ?? 2;
        $validated['organizer_id'] = $validated['organizer_id'] ?? null;
        $validated['created_user_name'] = Auth::user()->name ?? 'system';

        $course = Course::create($validated);

        // カテゴリ同期（論理削除対応）
        if ($request->filled('category_ids')) {
            foreach ($request->category_ids as $categoryId) {
                $existing = $course->categories()->withTrashed()->where('categories.id', $categoryId)->first();

                if ($existing) {
                    if ($existing->trashed()) {
                        $existing->restore();
                    }
                    $existing->pivot->update([
                        'is_show' => 1,
                        'updated_user_name' => Auth::user()->name,
                    ]);
                } else {
                    $course->categories()->attach($categoryId, [
                        'is_show' => 1,
                        'created_user_name' => Auth::user()->name,
                    ]);
                }
            }
        }

        return redirect()->route('admin.courses.index')->with('success', '講座を登録しました');
    }

    public function edit($id)
    {
        return view('admin.courses.edit', [
            'Course' => Course::findOrFail($id),
            'courseTypes' => CourseType::all(),
            'levels' => Level::all(),
            'organizers' => Organizer::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'course_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses', 'course_code')->ignore($course->id),
            ],
            'course_type_id' => 'required|exists:course_types,id',
            'level_id' => 'nullable|exists:levels,id',
            'organizer_id' => 'nullable|exists:organizers,id',
            'course_name' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'application_date' => 'nullable|date',
            'certification_date' => 'nullable|date',
            'certification_number' => 'nullable|string|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_hours' => 'nullable|integer',
            'periods' => 'nullable|integer',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable|date',
            'finish_viewing' => 'nullable|date',
            'plan_path' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls',
            'flier_path' => 'nullable|file|mimes:pdf,jpg,png,webp',
            'capacity' => 'nullable|integer',
            'entering' => 'nullable|integer',
            'completed' => 'nullable|integer',
            'description' => 'nullable|string',
            'mail_address' => 'nullable|email',
            'cc_address' => 'nullable|string',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'category_ids' => 'array',
            'category_ids.*' => 'integer',
        ]);

        if ($request->hasFile('plan_path')) {
            if ($course->plan_path) Storage::disk('public')->delete($course->plan_path);
            $validated['plan_path'] = $request->file('plan_path')->store('plans', 'public');
        }

        if ($request->hasFile('flier_path')) {
            if ($course->flier_path) Storage::disk('public')->delete($course->flier_path);
            $validated['flier_path'] = $request->file('flier_path')->store('fliers', 'public');
        }

        $validated['level_id'] = $validated['level_id'] ?? 2;
        $validated['updated_user_name'] = Auth::user()->name ?? 'system';

        $course->update($validated);

        // 中間テーブル更新（論理削除対応）
        $categoryIds = $request->input('category_ids', []);
        foreach ($categoryIds as $categoryId) {
            $existing = $course->categories()->withTrashed()->where('categories.id', $categoryId)->first();

            if ($existing) {
                if ($existing->trashed()) {
                    $existing->restore();
                }
                $existing->pivot->update([
                    'is_show' => 1,
                    'updated_user_name' => Auth::user()->name,
                ]);
            } else {
                $course->categories()->attach($categoryId, [
                    'is_show' => 1,
                    'created_user_name' => Auth::user()->name,
                ]);
            }
        }

        return redirect()->route('admin.courses.index')->with('success', '講座を更新しました');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->deleted_user_name = Auth::user()->name ?? 'system';
        $course->save();
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', '講座を削除しました');
    }

    public function students(Course $course)
    {
        $students = $course->students()->paginate(20);
        $teachers = $course->teachers()->paginate(20);
        return view('admin.courses.students', compact('course', 'students', 'teachers'));
    }
}
