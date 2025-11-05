<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();
        return view('status.index', compact('statuses'));
    }

    public function create()
    {
        return view('status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:100',
            'status'      => 'required|string|max:100',
            'keterangan'  => 'nullable|string',
            'tgl_update'  => 'required|date',
        ]);

        Status::create([
            'nama_status' => $request->nama_status,
            'status'      => $request->status,
            'keterangan'  => $request->keterangan,
            'tgl_update'  => $request->tgl_update, // ✅ diperbaiki dari tgl_dibuat
        ]);

        return redirect()->route('status.index')
                         ->with('success', 'Status berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('status.edit', compact('status'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_status' => 'required|string|max:255',
        'status'      => 'required|string|max:255',
        'keterangan'  => 'nullable|string',
        'tgl_update'  => 'required|date',
    ]);

    $status = Status::findOrFail($id);

    // Update dengan format tanggal yang aman
    $status->nama_status = $request->nama_status;
    $status->status = $request->status;
    $status->keterangan = $request->keterangan;
    $status->tgl_update = \Carbon\Carbon::parse($request->tgl_update)->format('Y-m-d');

    $status->save(); // gunakan save() bukan update()

    return redirect()->route('status.index')
        ->with('success', 'Data status berhasil diperbarui!');
}

    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->route('status.index')
                         ->with('success', 'Status berhasil dihapus!');
    }

    public function show($id)
{
    $status = Status::findOrFail($id);
    return view('status.show', compact('status'));
}
}
