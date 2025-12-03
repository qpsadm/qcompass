<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    /**
     * 今日の名言一覧ページ
     */
    public function index()
    {
        // 今日の名言をランダムで取得
        $todayQuote = Quote::where('is_show', true)->inRandomOrder()->first();

        // 現在の表示モード（full / mix）
        $quote_mode = session('quote_mode', 'full');

        $quote_parts = [];
        $author_parts = [];

        if ($quote_mode === 'mix' && $todayQuote) {
            // ABCパーツが無い場合でも空文字で埋める
            foreach (['A', 'B', 'C'] as $part) {
                $q = $todayQuote->quoteParts->firstWhere('part_type', $part);
                $a = $todayQuote->authorParts->firstWhere('part_type', $part);

                $quote_parts[]  = (object)['text' => $q?->text ?? ''];
                $author_parts[] = (object)['text' => $a?->text ?? ''];
            }

            // セッションに保存
            session([
                'mix_quote_parts'  => $quote_parts,
                'mix_author_parts' => $author_parts,
            ]);
        }

        return view('user.quotes.index', compact('todayQuote', 'quote_mode'));
    }

    /**
     * 表示モード切替 (full / mix)
     */
    public function toggleMode(Request $request)
    {
        $mode = $request->input('mode', 'full');

        if ($mode === 'mix') {

            $quote_parts_text  = [];
            $author_parts_text = [];

            // ランダム名言を取得
            $randomQuote = Quote::where('is_show', true)->inRandomOrder()->first();

            if ($randomQuote) {
                foreach (['A', 'B', 'C'] as $part) {
                    $quote_parts_text[$part]  = $randomQuote->quoteParts->firstWhere('part_type', $part)?->text ?? '';
                    $author_parts_text[$part] = $randomQuote->authorParts->firstWhere('part_type', $part)?->text ?? '';
                }
            }

            session([
                'mix_quote_parts'  => $quote_parts_text,
                'mix_author_parts' => $author_parts_text,
            ]);
        }

        session(['quote_mode' => $mode]);

        return redirect()->back();
    }
}
