<?php
// app/Http/Controllers/User/QuoteController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        // is_show = true のみ表示
        $quotes = Quote::where('is_show', true)->get();

        return view('user.quotes.index', compact('quotes'));
    }
}
