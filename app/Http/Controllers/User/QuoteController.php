<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * モード切替（フル／パーツ）
     */
    public function update(Request $request)
    {
        $mode = $request->input('mode', 'full'); // デフォルト full
        session(['quote_mode' => $mode]);
        return redirect()->back();
    }

    /**
     * 今日の一言取得
     */
    public static function todayQuote()
    {
        // 今日の一言を固定で取得
        $quote = Quote::where('is_show', true)
            ->whereDate('created_at', now()->toDateString()) // 今日の日付の名言
            ->inRandomOrder() // もし複数あればランダムで1件
            ->first();

        return $quote;
    }

    public function switchMode(Request $request)
    {
        $mode = $request->input('mode', 'full');

        if ($mode === 'mix') {
            // パーツモード用にランダムに3つの名言を取得
            $quotes = Quote::where('is_show', 1)->inRandomOrder()->limit(3)->get();

            // QuotePartsとAuthorPartsをまとめる
            $quote_parts = collect();
            $author_parts = collect();

            foreach ($quotes as $quote) {
                foreach ($quote->parts as $part) {
                    $quote_parts->push($part);
                }
                foreach ($quote->author_parts as $part) {
                    $author_parts->push($part);
                }
            }

            Session::put('quote_parts', $quote_parts);
            Session::put('author_parts', $author_parts);
        }

        Session::put('quote_mode', $mode);

        return redirect()->back();
    }
}
