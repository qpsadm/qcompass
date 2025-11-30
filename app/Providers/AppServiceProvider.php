<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Quote;
use App\Services\QuoteService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('includes.f_side_menu', function ($view) {
            $user = Auth::user();
            $courses = $user ? $user->courses()->where('is_show', 1)->get() : collect();

            // 今日の名言（フル名言からランダム）
            $todayQuote = Quote::where('is_show', 1)->inRandomOrder()->first();

            $view->with([
                'courses' => $courses,
                'todayQuote' => $todayQuote,
            ]);
        });
    }
}
