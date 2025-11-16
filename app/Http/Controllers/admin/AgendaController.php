<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Category;
use Mews\Purifier\Facades\Purifier;

class AgendaController extends Controller
{
    protected $allowedTags = [
        'p',
        'br',
        'b',
        'i',
        'strong',
        'em',
        'u',
        'a[href|title|target]',
        'ul',
        'ol',
        'li',
        'img[src|alt|title|width|height|style]',
        'figure',
        'figcaption',
        'iframe[src|width|height|frameborder|allowfullscreen]',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'blockquote',
        'table',
        'thead',
        'tbody',
        'tfoot',
        'tr',
        'td',
        'th',
        'col',
        'colgroup'
    ];

    public function index()
    {
        $agendas = Agenda::with('user')->whereNull('deleted_at')->get();
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
        $agenda = Agenda::with(['category', 'createdUser', 'updatedUser'])->findOrFail($id);

        $agenda->description_sanitized = Purifier::clean($agenda->description, [
            'HTML.Allowed' => implode(',', $this->allowedTags),
            'HTML.SafeIframe' => true,
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => false,
            'Attr.EnableID' => true,
            'HTML.AllowedAttributes' => implode(',', [
                'style',
                'dir',
                'class',
                'id',
                'src',
                'alt',
                'title',
                'width',
                'height',
                'href',
                'target',
                'frameborder',
                'allowfullscreen',
                'action',
                'method',
                'name',
                'type',
                'value',
                'colspan',
                'rowspan',
                'align',
                'valign',
                'border',
                'cellpadding',
                'cellspacing'
            ]),
            'CSS.AllowedProperties' => implode(',', [
                'color',
                'background-color',
                'font-size',
                'font-weight',
                'font-style',
                'text-decoration',
                'margin',
                'padding',
                'border',
                'border-collapse',
                'width',
                'height',
                'text-align',
                'vertical-align',
                'max-width',
                'display'
            ]),
            'CSS.AllowTricky' => true,
            'HTML.Trusted' => true,
            'URI.AllowedSchemes' => [
                'http' => true,
                'https' => true,
                'mailto' => true,
                'data' => true // ← base64画像対応
            ],
        ]);

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

        // CKEditorのHTMLをデコードして保存
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

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $rootCategories = Category::with('children')->whereNull('parent_id')->get();
        $categories = $this->buildCategoryOptions($rootCategories);
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

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました。');
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
    public function trash()
    {
        $agendas = Agenda::onlyTrashed()->get();
        return view('admin.agendas.trash', compact('agendas'));
    }
    public function restore($id)
    {
        $agenda = Agenda::onlyTrashed()->findOrFail($id);
        $agenda->restore();

        return redirect()->route('admin.agendas.trash')->with('success', 'アジェンダを復元しました。');
    }
}
