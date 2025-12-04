<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Storage;

class JobOfferController extends Controller
{
    /**
     * 求人票一覧
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $search = $request->input('search');

        $job_offers = JobOffer::query();

        if ($search) {
            $job_offers->where('title', 'like', "%{$search}%");
        }

        $job_offers = $job_offers->orderBy($sort, $order)
            ->paginate(10)
            ->appends($request->query());

        return view('job_offers.index', compact('job_offers', 'sort', 'order', 'search'));
    }

    /**
     * 作成フォーム
     */
    public function create()
    {
        return view('job_offers.create');
    }

    /**
     * 新規作成
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:512', // 長文のためコメントアウト 福島←解除しますby尾上
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
        ]);

        $validated['is_show'] = $request->boolean('is_show'); // ← ここを修正
        $validated['created_user_name'] = auth()->user()->name ?? 'Unknown';
        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        // PDFファイルの保存
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('job_offers', 'public');
            $validated['file_path'] = $path;
        }

        JobOffer::create($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を作成しました');
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.edit', compact('job_offer'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $job_offer = JobOffer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:512', // 長文のためコメントアウト 福島←解除しますby尾上
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
        ]);

        $validated['is_show'] = $request->boolean('is_show'); // ← 修正
        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        // PDFファイルの更新
        if ($request->hasFile('pdf_file')) {
            // 既存ファイル削除（必要なら）
            if ($job_offer->file_path && Storage::disk('public')->exists($job_offer->file_path)) {
                Storage::disk('public')->delete($job_offer->file_path);
            }

            $path = $request->file('pdf_file')->store('job_offers', 'public');
            $validated['file_path'] = $path;
        }

        $job_offer->update($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を更新しました');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.show', compact('job_offer'));
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        $job_offer->deleted_user_name = auth()->user()->name ?? 'システム';
        $job_offer->save();
        $job_offer->delete();

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を削除しました');
    }
}
