<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::where('is_show', true)->get();
        return view('user.quotes.index', compact('quotes'));
    }

    public function toggleMode(Request $request)
    {
        $mode = $request->input('mode', 'full');

        if ($mode === 'mix') {

            $quote_parts_text  = [];
            $author_parts_text = [];

            foreach (['A', 'B', 'C'] as $part) {

                // 各パーツ用にランダム名言を1件取得
                $randomQuote = Quote::where('is_show', true)->inRandomOrder()->first();
                if (!$randomQuote) continue;

                $quotePart  = $randomQuote->quoteParts->firstWhere('part_type', $part);
                $authorPart = $randomQuote->authorParts->firstWhere('part_type', $part);

                $quote_parts_text[$part]  = $quotePart?->text  ?? '';
                $author_parts_text[$part] = $authorPart?->text ?? '';
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
