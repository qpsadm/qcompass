<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certifications; // ← ここ！

class CertificationsController extends Controller
{
    public function index()
    {
        $certifications = Certifications::all();
        return view('certifications.index', compact('certifications'));
    }

    public function create()
    {
        return view('certifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|integer|min:1|max:2',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'display_flag' => 'nullable|boolean',
        ]);

        Certifications::create($validated);

        return redirect()->route('admin.certifications.index')->with('success', '資格作成完了');
    }

    public function show($id)
    {
        $certification = Certifications::findOrFail($id);
        return view('certifications.show', compact('certification'));
    }

    public function edit($id)
    {
        $certification = Certifications::findOrFail($id);
        return view('certifications.edit', compact('certification'));
    }

    public function update(Request $request, $id)
    {
        $certification = Certifications::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|integer|min:1|max:2',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'display_flag' => 'nullable|boolean',
        ]);

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')->with('success', '資格更新完了');
    }

    public function destroy($id)
    {
        Certifications::findOrFail($id)->delete();
        return redirect()->route('admin.certifications.index')->with('success', '資格削除完了');
    }
}