<?php
// app/Http/Controllers/User/QuoteController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        // is_show = true のみ表示
        $quotes = Quote::where('is_show', true)->get();

        return view('user.quotes.index', compact('quotes'));
    }

    public function toggleMode(Request $request)
    {
        $mode = $request->input('mode', 'full');

        if ($mode === 'mix') {
            // パーツモード用に今日の名言を分割
            $todayQuote = Quote::find(Session::get('today_quote_id'));
            if ($todayQuote) {
                $parts = $todayQuote->parts()->get(); // quote_parts リレーション
                $authorParts = $todayQuote->authorParts()->get(); // author_parts リレーション

                // ランダムシャッフル
                $parts = $parts->shuffle();
                $authorParts = $authorParts->shuffle();

                Session::put('quote_parts', $parts);
                Session::put('author_parts', $authorParts);
            }
        }

        // モード更新
        Session::put('quote_mode', $mode);

        return redirect()->back();
    }
}
