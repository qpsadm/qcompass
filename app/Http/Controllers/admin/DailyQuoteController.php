<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyQuote;

class DailyQuoteController extends Controller
{
    public function index()
    {
        $daily_quotes = DailyQuote::all();
        return view('admin.daily_quotes.index', compact('daily_quotes'));
    }

    public function create()
    {
        return view('admin.daily_quotes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote' => 'nullable',
            'author' => 'nullable',
            'display_date' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        DailyQuote::create($validated);
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote作成完了');
    }

    public function show($id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        return view('admin.daily_quotes.show', compact('DailyQuote'));
    }

    public function edit($id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        return view('admin.daily_quotes.edit', compact('DailyQuote'));
    }

    public function update(Request $request, $id)
    {
        $DailyQuote = DailyQuote::findOrFail($id);
        $validated = $request->validate([
            'quote' => 'nullable',
            'author' => 'nullable',
            'display_date' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $DailyQuote->update($validated);
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote更新完了');
    }

    public function destroy($id)
    {
        DailyQuote::findOrFail($id)->delete();
        return redirect()->route('admin.daily_quotes.index')->with('success', 'DailyQuote削除完了');
    }
}