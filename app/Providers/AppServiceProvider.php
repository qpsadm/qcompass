<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Course;
use App\Models\Quote;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('includes.f_side_menu', function ($view) {
            $user = Auth::user();

            $courses = $user ? $user->courses()->where('is_show', 1)->get() : collect();

            // 今日の一言（フルモード）
            if (!Session::has('today_quote_id')) {
                $todayQuote = Quote::where('is_show', 1)->inRandomOrder()->first();
                Session::put('today_quote_id', $todayQuote?->id);
            } else {
                $todayQuote = Quote::find(Session::get('today_quote_id'));
            }

            $quote_mode = Session::get('quote_mode', 'full');

            // パーツモードで複数名言を混ぜる
            if ($quote_mode === 'mix') {
                $quotes = Quote::where('is_show', 1)->inRandomOrder()->take(3)->get(); // A, B, C
                $quoteParts = collect();
                $authorParts = collect();

                foreach ($quotes as $quote) {
                    $quoteParts->push($quote->quoteParts()->inRandomOrder()->first()); // 各名言から1パーツずつ
                    $authorParts->push($quote->authorParts()->inRandomOrder()->first());
                }

                Session::put('quote_parts', $quoteParts);
                Session::put('author_parts', $authorParts);
            }

            $view->with([
                'courses' => $courses,
                'todayQuote' => $todayQuote,
                'quote_mode' => $quote_mode,
            ]);
        });
    }
}
