<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;

class JobOfferController extends Controller
{
    // 求人票一覧
    public function index()
    {
        $job_offers = JobOffer::orderBy('created_at', 'desc')->get();
        return view('job_offers.index', compact('job_offers'));
    }

    // 新規作成フォーム
    public function create()
    {
        return view('job_offers.create');
    }

    // 保存処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:512',
            'file_path' => 'nullable|string|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'is_show' => 'nullable|boolean',
        ]);

        // チェックボックス対応
        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        // 作成者名 / 更新者名
        $validated['created_user_name'] = auth()->user()->name ?? 'Unknown';

        $validated['updated_user_name'] = auth()->user()->name ?? 'システム';


        JobOffer::create($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を作成しました');
    }

    // 詳細表示
    public function show($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.show', compact('job_offer'));
    }

    // 編集フォーム
    public function edit($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.edit', compact('job_offer'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $job_offer = JobOffer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:512',
            'file_path' => 'nullable|string|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'is_show' => 'nullable|boolean',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        $job_offer->update($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を更新しました');
    }

    // 削除
    public function destroy($id)
    {
        $job_offer = JobOffer::findOrFail($id);

        // 削除者名を設定してからソフトデリート
        $job_offer->deleted_user_name = auth()->user()->name ?? 'システム';
        $job_offer->save();

        $job_offer->delete();

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を削除しました');
    }
}
