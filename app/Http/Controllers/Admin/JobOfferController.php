<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        return view('admin.job_offers.index', compact('job_offers', 'sort', 'order', 'search'));
    }

    /**
     * 作成フォーム
     */
    public function create()
    {
        return view('admin.job_offers.create');
    }

    /**
     * 新規作成
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file1' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file2' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file3' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file4' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file5' => 'nullable|file|mimes:pdf|max:4096',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
        ]);

        $validated['is_show'] = $request->boolean('is_show');
        $validated['created_user_name'] = auth()->user()->name ?? 'Unknown';
        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        // PDFファイルをまとめて保存
        foreach (range(1, 5) as $i) {
            $inputName = 'pdf_file' . $i;
            // $columnName = 'file_path' . ($i === 1 ? '' : $i);
            $columnName = 'file_path' . $i;

            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                // $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // $extension = $file->getClientOriginalExtension();
                // $fileName = now()->format('Ymd') . '-' . Str::slug($originalName) . '.' . $extension;
                // $fileName = now()->format('Ymd') . '-' . $i . '.' . $extension;

                // 保存ファイル別名を取得
                $newFileName = $request->input('newFileName' . $i);

                $path = $file->storeAs('job_offers', $newFileName, 'public');
                $validated[$columnName] = $path;
            }
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
        return view('admin.job_offers.edit', compact('job_offer'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $job_offer = JobOffer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file1' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file2' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file3' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file4' => 'nullable|file|mimes:pdf|max:4096',
            'pdf_file5' => 'nullable|file|mimes:pdf|max:4096',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
        ]);

        $validated['is_show'] = $request->boolean('is_show');
        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        // PDFファイル更新
        foreach (range(1, 5) as $i) {
            $inputName  = 'pdf_file' . $i;
            $deleteName = 'delete_pdf' . $i;
            // $columnName = 'file_path' . ($i === 1 ? '' : $i);
            $columnName = 'file_path' . $i;

            /*
     |------------------------------------------
     | 削除チェックが入っている場合
     |------------------------------------------
     */
            if ($request->boolean($deleteName)) {
                if ($job_offer->$columnName && Storage::disk('public')->exists($job_offer->$columnName)) {
                    Storage::disk('public')->delete($job_offer->$columnName);
                }
                $validated[$columnName] = null;
            }

            /*
     |------------------------------------------
     | 新しいPDFがアップロードされた場合
     |（削除チェックより優先）
     |------------------------------------------
     */
            if ($request->hasFile($inputName)) {

                // 既存ファイル削除
                if ($job_offer->$columnName && Storage::disk('public')->exists($job_offer->$columnName)) {
                    Storage::disk('public')->delete($job_offer->$columnName);
                }

                $file = $request->file($inputName);
                // $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // $extension = $file->getClientOriginalExtension();
                // $fileName = now()->format('Ymd') . '-' . Str::slug($originalName) . '.' . $extension;
                // $fileName = now()->format('YmdHis') . '-' . $i . '.' . $extension;
                // $path = $file->storeAs('job_offers', $fileName, 'public');

                // 保存ファイル別名を取得
                $newFileName = $request->input('newFileName' . $i);
                // ファイルをアップロード
                $path = $file->storeAs('job_offers', $newFileName, 'public');
                $validated[$columnName] = $path;
            }
        }

        // テーブルにアップデート
        $job_offer->update($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を更新しました');
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        $job_offer = JobOffer::findOrFail($id);

        // 全てのPDFファイルを削除
        foreach (range(1, 5) as $i) {
            // $columnName = 'file_path' . ($i === 1 ? '' : $i);
            $columnName = 'file_path' . $i;
            if ($job_offer->$columnName && Storage::disk('public')->exists($job_offer->$columnName)) {
                Storage::disk('public')->delete($job_offer->$columnName);
            }
        }

        // 削除ユーザー名を記録して論理削除
        // $job_offer->deleted_user_name = auth()->user()->name ?? 'システム';
        // $job_offer->save();
        // $job_offer->delete();

        // 物理削除するように変更
        if ($job_offer) {
            // 完全にデータベースから削除
            $job_offer->forceDelete();
        }

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を削除しました');
    }
}