<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index()
    {
        $job_offers = JobOffer::orderBy('created_at', 'desc')->get();
        return view('job_offers.index', compact('job_offers'));
    }

    public function create()
    {
        return view('job_offers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 長文になる可能性があるため、コメントアウトした　福島
            // 'description' => 'nullable|string|max:512',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'is_show' => 'nullable|boolean',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
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

    public function edit($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.edit', compact('job_offer'));
    }

    public function update(Request $request, $id)
    {
        $job_offer = JobOffer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 長文になる可能性があるため、コメントアウトした　福島
            // 'description' => 'nullable|string|max:512',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'is_show' => 'nullable|boolean',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['updated_user_name'] = auth()->user()->name ?? 'Unknown';

        // PDFファイルの更新
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('job_offers', 'public');
            $validated['file_path'] = $path;
        }

        $job_offer->update($validated);

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を更新しました');
    }

    public function show($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        return view('job_offers.show', compact('job_offer'));
    }

    public function destroy($id)
    {
        $job_offer = JobOffer::findOrFail($id);
        $job_offer->deleted_user_name = auth()->user()->name ?? 'システム';
        $job_offer->save();
        $job_offer->delete();

        return redirect()->route('admin.job_offers.index')->with('success', '求人票を削除しました');
    }
}
