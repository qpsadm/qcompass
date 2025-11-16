<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Category;
use Mews\Purifier\Facades\Purifier;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('user')->get(); // ← eager load で N+1 問題回避
        foreach ($agendas as $agenda) {
            $agenda->description_sanitized = Purifier::clean($agenda->description);
        }
        return view('admin.agendas.index', compact('agendas'));
    }
    public function create()
    {
        $rootCategories = Category::with('children')->whereNull('parent_id')->get();
        $categories = $this->buildCategoryOptions($rootCategories);

        return view('admin.agendas.create', compact('categories'));
    }

    public function show($id)
    {
        $agenda = Agenda::with('category')->find($id);

        if (!$agenda) {
            abort(404);
        }

        return view('admin.agendas.show', [
            'Agenda' => $agenda,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
        ]);

        // CKEditorのHTMLを安全化
        if (isset($validated['description'])) {
            $validated['description'] = Purifier::clean($validated['description']);
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        // ログインユーザーのIDを追加
        $validated['user_id'] = auth()->id();
        $validated['created_user_id'] = auth()->id();

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを作成しました。');
    }
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $categories = Category::all();
        return view('admin.agendas.edit', compact('agenda', 'categories'));
    }


    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
            'user_id' => 'nullable|integer',
        ]);

        if (isset($validated['description'])) {
            $validated['description'] = Purifier::clean($validated['description']);
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['created_user_id'] = auth()->id();

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを更新しました。');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました。');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    private function buildCategoryOptions($categories, $prefix = '')
    {
        $options = [];

        foreach ($categories as $category) {
            $options[] = [
                'id' => $category->id,
                'name' => $prefix . $category->name,
            ];

            if ($category->children->isNotEmpty()) {
                $childOptions = $this->buildCategoryOptions($category->children, $prefix . '— ');
                $options = array_merge($options, $childOptions);
            }
        }

        return $options;
    }
}
