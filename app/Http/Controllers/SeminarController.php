<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\NotifikasiPKL;
use App\Models\User;

class SeminarController extends Controller
{
    public function index()
    {
        $seminars = Seminar::latest()->paginate(10);
        return view('seminar.index', compact('seminars'));
    }

    public function create()
    {
        return view('seminar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa'    => 'required|string|max:255',
            'nim'               => 'required|string|max:20',
            'nama_pembimbing'   => 'required|string|max:255',
            'nama_penguji'      => 'required|string|max:255',
            'judul'             => 'required|string',
            'tanggal'           => 'required|date',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
            'ruang'             => 'required|string|max:50',
        ]);

        Seminar::create($request->all());

        return redirect()->route('seminar.index')->with('success', 'Jadwal seminar berhasil ditambahkan.');
    }

    public function show(Seminar $seminar)
    {
        return view('seminar.show', compact('seminar'));
    }

    public function edit(Seminar $seminar)
    {
        return view('seminar.edit', compact('seminar'));
    }

    public function update(Request $request, Seminar $seminar)
    {
        $request->validate([
            'nama_mahasiswa'    => 'required|string|max:255',
            'nim'               => 'required|string|max:20',
            'nama_pembimbing'   => 'required|string|max:255',
            'nama_penguji'      => 'required|string|max:255',
            'judul'             => 'required|string',
            'tanggal'           => 'required|date',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
            'ruang'             => 'required|string|max:50',
        ]);

        $seminar->update($request->all());

        return redirect()->route('seminar.index')->with('success', 'Jadwal seminar berhasil diperbarui.');
    }

    public function destroy(Seminar $seminar)
    {
        $seminar->delete();
        return redirect()->route('seminar.index')->with('success', 'Jadwal seminar berhasil dihapus.');
    }

    public function jadwalkanSeminar($mahasiswaId)
    {
        $mahasiswa = User::findOrFail($mahasiswaId);

        $mahasiswa->notify(
            new NotifikasiPKL(
                'Seminar PKL Dijadwalkan',
                'Seminar PKL Anda dijadwalkan pada 15 Januari 2025 pukul 10.00 WIB.',
                route('seminar.jadwal')
            )
        );

        return back()->with('success', 'Notifikasi berhasil dikirim');
    }
}