<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Course;
use App\Models\Category;
use Mews\Purifier\Facades\Purifier;

class AgendaController extends Controller
{
    /**
     * CKEditorで許可するHTMLタグ
     */
    protected $allowedTags = [
        'p',
        'br',
        'b',
        'i',
        'strong',
        'em',
        'u',
        'a[href|title|target|rel|name]',
        'span[style|class|id|title|dir]',
        'div[style|class|id|title|dir]',
        'ul',
        'ol',
        'li',
        'img[src|alt|title|width|height|style|class|id]',
        'figure[style|class|id]',
        'figcaption[style|class|id]',
        'iframe[src|width|height|frameborder|allowfullscreen|style|class|id|title]',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'blockquote[cite|style|class|id]',
        'table[style|class|id|border|cellspacing|cellpadding]',
        'thead[style|class|id]',
        'tbody[style|class|id]',
        'tfoot[style|class|id]',
        'tr[style|class|id]',
        'td[style|class|id|colspan|rowspan|align|valign]',
        'th[style|class|id|colspan|rowspan|align|valign]',
        'col[style|class|id|span]',
        'colgroup[style|class|id|span]',
        'pre',
        'code',
        'hr',
        'small',
        'sub',
        'sup',
        'mark',
        'abbr[title|style|class|id]',
        'address'
    ];




    /**
     * アジェンダ一覧
     */
    public function index()
    {
        $agendas = Agenda::with('user')->whereNull('deleted_at')->get();

        foreach ($agendas as $agenda) {
            $agenda->description_sanitized = Purifier::clean($agenda->description);
        }

        return view('admin.agendas.index', compact('agendas'));
    }

    /**
     * アジェンダ作成画面
     */
    public function create()
    {
        $rootCategories = Category::with('children')->whereNull('parent_id')->get();
        $courses = Course::where('is_show', 1)->get(); // 表示フラグが立っている講座のみ
        $categories = $this->buildCategoryOptions($rootCategories);

        return view('admin.agendas.create', compact('categories', 'courses'));
    }
    /**
     * アジェンダ詳細
     */
    public function show($id)
    {
        $agenda = Agenda::with(['category', 'createdUser', 'updatedUser'])->findOrFail($id);

        // ← ここで Purifier を使って description をサニタイズ
        $agenda->description_sanitized = Purifier::clean($agenda->description, [
            'HTML.Allowed' => implode(',', $this->allowedTags),
            'HTML.SafeIframe' => true,
            'CSS.AllowTricky' => true,
            'HTML.Trusted' => true,
        ]);

        return view('admin.agendas.show', [
            'Agenda' => $agenda,
        ]);
    }


    /**
     * アジェンダ保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
        ]);

        // CKEditorのHTMLデコード
        if (!empty($validated['description'])) {
            $decoded = htmlspecialchars_decode(html_entity_decode($validated['description'], ENT_QUOTES | ENT_HTML5));
            $decoded = str_replace('&nbsp;', ' ', $decoded);
            $validated['description'] = $decoded;
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['user_id'] = auth()->id();
        $validated['created_user_id'] = auth()->id();

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを作成しました');
    }

    /**
     * 編集画面
     */
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $rootCategories = Category::with('children')->whereNull('parent_id')->get();
        $categories = $this->buildCategoryOptions($rootCategories);
        $courses = Course::where('is_show', 1)->get();

        return view('admin.agendas.edit', compact('agenda', 'categories', 'courses'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
        ]);

        if (!empty($validated['description'])) {
            $decoded = htmlspecialchars_decode(html_entity_decode($validated['description']), ENT_QUOTES | ENT_HTML5);
            $decoded = str_replace('&nbsp;', ' ', $decoded);
            $validated['description'] = $decoded;
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['updated_user_id'] = auth()->id();

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを更新しました');
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました。');
    }

    /**
     * 論理削除済みの一覧
     */
    public function trash()
    {
        $agendas = Agenda::onlyTrashed()->get();
        return view('admin.agendas.trash', compact('agendas'));
    }

    /**
     * 論理削除から復元
     */
    public function restore($id)
    {
        $agenda = Agenda::onlyTrashed()->findOrFail($id);
        $agenda->restore();

        return redirect()->route('admin.agendas.trash')->with('success', 'アジェンダを復元しました。');
    }

    /**
     * カテゴリをツリー形式でオプション配列に変換
     */
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
