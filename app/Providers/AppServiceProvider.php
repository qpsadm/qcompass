<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Course;
use App\Models\Quote;
use App\Models\UserDetail; // ← 追加
use Carbon\Carbon;           // ← 追加

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer(['includes.f_side_menu', 'includes.f_header'], function ($view) {
            $user = Auth::user();

            // ログインユーザーのコース取得
            $courses = $user ? $user->courses()->where('is_show', 1)->get() : collect();

            // 今日の一言
            if (!Session::has('today_quote_id')) {
                $todayQuote = Quote::where('is_show', 1)->inRandomOrder()->first();
                Session::put('today_quote_id', $todayQuote?->id);
            } else {
                $todayQuote = Quote::find(Session::get('today_quote_id'));
            }

            $quote_mode = Session::get('quote_mode', 'full');

            // パーツモード（mix）
            if ($quote_mode === 'mix') {
                $quotes = Quote::where('is_show', 1)->inRandomOrder()->take(3)->get();
                $quoteParts = collect();
                $authorParts = collect();

                foreach ($quotes as $quote) {
                    $quoteParts->push($quote->quoteParts()->inRandomOrder()->first());
                    $authorParts->push($quote->authorParts()->inRandomOrder()->first());
                }

                Session::put('quote_parts', $quoteParts);
                Session::put('author_parts', $authorParts);
            }

            // ----------------------------
            // 誕生日判定
            // ----------------------------
            $isBirthday = false;
            if ($user) {
                $userDetail = UserDetail::where('user_id', $user->id)->first();
                if ($userDetail && $userDetail->birthday) {
                    $birthday = Carbon::parse($userDetail->birthday);
                    if ($birthday->format('m-d') === Carbon::now()->format('m-d')) {
                        $isBirthday = true;
                    }
                }
            }

            // ビューに渡す
            $view->with([
                'courses' => $courses,
                'todayQuote' => $todayQuote,
                'quote_mode' => $quote_mode,
                'isBirthday' => $isBirthday, // ← 追加
            ]);
        });
    }
}
