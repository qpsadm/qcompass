<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Quote;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // AppServiceProvider.php
        View::composer('includes.f_side_menu', function ($view) {
            $user = Auth::user();
            $courses = $user ? $user->courses()->where('is_show', 1)->get() : collect();

            $quote_mode = Session::get('quote_mode', 'full');

            if ($quote_mode === 'mix') {
                // ランダムで3つの名言を取得
                $quotes = Quote::where('is_show', 1)->inRandomOrder()->limit(3)->get();

                $mixedParts = collect();
                $authorParts = collect();

                foreach ($quotes as $quote) {
                    $mixedParts = $mixedParts->merge($quote->quoteParts()->inRandomOrder()->take(1)->get());
                    $authorParts = $authorParts->merge($quote->authorParts()->inRandomOrder()->take(1)->get());
                }

                Session::put('quote_parts', $mixedParts);
                Session::put('author_parts', $authorParts);
            } else {
                Session::forget('quote_parts');
                Session::forget('author_parts');
            }

            // 今日の一言（1つ固定）
            $todayKey = 'today_quote_' . date('Y-m-d');
            if (!Session::has($todayKey)) {
                $quote = Quote::where('is_show', 1)->inRandomOrder()->first();
                Session::put($todayKey, $quote);
            } else {
                $quote = Session::get($todayKey);
            }

            $view->with([
                'courses' => $courses,
                'todayQuote' => $quote,
                'quote_mode' => $quote_mode,
            ]);
        });
    }
}
