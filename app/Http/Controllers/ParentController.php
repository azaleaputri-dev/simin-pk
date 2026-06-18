<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index()
    {
        $parents = Guardian::withCount('students')->latest()->get();

        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        return view('parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:parents,email',
            'phone' => 'required|string|max:20|unique:parents,phone',
            'address' => 'required|string',
        ]);

        Guardian::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'father_name' => $validated['name'],
            'mother_name' => $validated['name'],
        ]);

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $parent = Guardian::findOrFail($id);

        return view('parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = Guardian::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:parents,email,' . $parent->id,
            'phone' => 'required|string|max:20|unique:parents,phone,' . $parent->id,
            'address' => 'required|string',
        ]);

        $parent->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'father_name' => $validated['name'],
            'mother_name' => $validated['name'],
        ]);

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Guardian::findOrFail($id)->delete();

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil dihapus.');
    }
}
