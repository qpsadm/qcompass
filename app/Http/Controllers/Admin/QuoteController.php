<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuotePart;
use App\Models\AuthorPart;

class QuoteController extends Controller
{
    // 一覧表示
    public function index()
    {
        $quotes = Quote::with(['quoteParts', 'authorParts'])->latest()->paginate(20);
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

    public function show(Request $request, Quote $quote)
    {
        $mode = $request->query('mode', 'normal'); // default: normal

        $quote_text = '';
        $author_text = '';

        if ($mode === 'normal') {
            // 原文モード
            $quote_text = $quote->quote_full;
            $author_text = $quote->author_full;
        } else {
            // ランダムモード
            $parts = ['A', 'B', 'C'];

            foreach ($parts as $part) {
                // ランダムに名言を取得
                $randomQuote = Quote::inRandomOrder()->first();

                // 本文パーツ
                $partText = $randomQuote->quoteParts
                    ->where('part_type', $part)
                    ->first()
                    ->text ?? '';

                // 作者パーツ
                $authorPartText = $randomQuote->authorParts
                    ->where('part_type', $part)
                    ->first()
                    ->text ?? '';

                $quote_text .= $partText;
                $author_text .= $authorPartText;
            }
        }

        return view('admin.quotes.show', compact('quote', 'quote_text', 'author_text', 'mode'));
    }
}
