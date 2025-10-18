<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DataDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Dosen::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $dosens = $query->latest()->paginate(10)->withQueryString();
        return view('datadosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('datadosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nip'              => 'required|string|max:20|unique:dosens,nip',
            'nama'              => 'required|string|max:255',
            'jabatan'             => 'required|string|max:100',
        ]);

        Dosen::create($request->all());

        return redirect()->route('datadosen.index')
                         ->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $datadosen): View
    {
        return view('datadosen.show', compact('datadosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $datadosen): View
    {
        return view('datadosen.edit', compact('datadosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $datadosen): RedirectResponse
    {
        $request->validate([
            'nip'              => ['required','string','max:20', Rule::unique('dosens')->ignore($datadosen->id)],
            'nama'              => 'required|string|max:255',
            'jabatan'             => 'required|string|max:100',
        ]);

        $datadosen->update($request->all());

        return redirect()->route('datadosen.index')
                         ->with('success', 'Data Dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $datadosen): RedirectResponse
    {
        $datadosen->delete();

        return redirect()->route('datadosen.index')
                         ->with('success', 'Data Dosen berhasil dihapus.');
    }
}
