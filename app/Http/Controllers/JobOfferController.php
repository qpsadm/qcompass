<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index()
    {
        $job_offers = JobOffer::all();
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
            'description' => 'required|string|max:512',
            'start_datetime' => 'nullable',
            'end_datetime' => 'nullable',
            'is_show' => 'required|boolean',
        ]);
        JobOffer::create($validated);
        return redirect()->route('job_offers.index')->with('success', 'JobOffer作成完了');
    }

    public function show($id)
    {
        $JobOffer = JobOffer::findOrFail($id);
        return view('job_offers.show', compact('JobOffer'));
    }

    public function edit($id)
    {
        $JobOffer = JobOffer::findOrFail($id);
        return view('job_offers.edit', compact('JobOffer'));
    }

    public function update(Request $request, $id)
    {
        $JobOffer = JobOffer::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:512',
            'start_datetime' => 'nullable',
            'end_datetime' => 'nullable',
            'is_show' => 'required|boolean',
        ]);
        $JobOffer->update($validated);
        return redirect()->route('job_offers.index')->with('success', 'JobOffer更新完了');
    }

    public function destroy($id)
    {
        JobOffer::findOrFail($id)->delete();
        return redirect()->route('job_offers.index')->with('success', 'JobOffer削除完了');
    }
}