<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuotePart;
use App\Models\AuthorPart;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    // 一覧表示
    public function index()
    {
        // ABCパーツがなくても全件取得
        $quotes = Quote::orderBy('id', 'desc')->paginate(20);

        return view('admin.quotes.index', compact('quotes'));
    }

    // 作成フォーム
    public function create()
    {
        return view('admin.quotes.create'); // $quote は渡さない
    }

    // 保存
    public function store(Request $request)
    {
        $request->validate([
            'quote_full' => 'required|string|max:255',
            'author_full' => 'nullable|string|max:255',
            'quote_parts.A' => 'required|string|max:255',
            'quote_parts.B' => 'required|string|max:255',
            'quote_parts.C' => 'required|string|max:255',
            'author_parts.A' => 'required|string|max:255',
            'author_parts.B' => 'required|string|max:255',
        ]);

        // 原文保存
        $quote = Quote::create([
            'quote_full' => $request->quote_full,
            'author_full' => $request->author_full,
            'is_show' => true,
        ]);

        // 名言パーツ保存
        foreach ($request->quote_parts as $part => $text) {
            QuotePart::create([
                'quote_id' => $quote->id,
                'part_type' => $part,
                'text' => $text,
                'weight' => 100,
            ]);
        }

        // 作者パーツ保存
        foreach ($request->author_parts as $part => $text) {
            AuthorPart::create([
                'quote_id' => $quote->id,
                'part_type' => $part,
                'text' => $text,
                'weight' => 100,
            ]);
        }

        return redirect()->route('admin.quotes.index')->with('success', '名言を登録しました。');
    }

    // 編集フォーム
    public function edit($id)
    {
        $quote = Quote::with(['quoteParts', 'authorParts'])->findOrFail($id);
        return view('admin.quotes.edit', compact('quote'));
    }

    // 更新
    public function update(Request $request, Quote $quote)
    {
        $request->validate([
            'quote_full' => 'required|string|max:255',
            'author_full' => 'nullable|string|max:255',
            'quote_parts.A' => 'required|string|max:255',
            'quote_parts.B' => 'required|string|max:255',
            'quote_parts.C' => 'required|string|max:255',
            'author_parts.A' => 'required|string|max:255',
            'author_parts.B' => 'required|string|max:255',
        ]);

        // 原文更新
        $quote->update([
            'quote_full' => $request->quote_full,
            'author_full' => $request->author_full,
        ]);

        // 名言パーツ更新
        foreach ($request->quote_parts as $part => $text) {
            $quotePart = $quote->quoteParts()->where('part_type', $part)->first();
            if ($quotePart) {
                $quotePart->update(['text' => $text]);
            } else {
                $quote->quoteParts()->create([
                    'part_type' => $part,
                    'text' => $text,
                    'weight' => 100,
                ]);
            }
        }

        // 作者パーツ更新
        foreach ($request->author_parts as $part => $text) {
            $authorPart = $quote->authorParts()->where('part_type', $part)->first();
            if ($authorPart) {
                $authorPart->update(['text' => $text]);
            } else {
                $quote->authorParts()->create([
                    'part_type' => $part,
                    'text' => $text,
                    'weight' => 100,
                ]);
            }
        }

        return redirect()->route('admin.quotes.index')->with('success', '名言を更新しました。');
    }

    // 削除
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', '削除完了');
    }

    public function toggleMode(Request $request)
    {
        $mode = $request->input('mode', 'full');

        if ($mode === 'mix') {

            $quote_text = '';
            $author_text = '';

            // 1つのランダム名言を取得
            $randomQuote = Quote::where('is_show', true)->inRandomOrder()->first();

            if ($randomQuote) {
                foreach (['A', 'B', 'C'] as $part) {
                    $quotePart = $randomQuote->quoteParts->firstWhere('part_type', $part);
                    $authorPart = $randomQuote->authorParts->firstWhere('part_type', $part);

                    $quote_text .= $quotePart?->text ?? '';
                    $author_text .= $authorPart?->text ?? '';
                }
            }

            session([
                'mix_quote_text'  => $quote_text,
                'mix_author_text' => $author_text,
            ]);
        }

        session(['quote_mode' => $mode]);

        return redirect()->back();
    }
}
