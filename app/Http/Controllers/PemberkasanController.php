<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pemberkasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PemberkasanController extends Controller
{
    /**
     * Tampilkan semua data pemberkasan.
     */
    public function index(): View
    {
        $pemberkasan = Pemberkasan::with('mahasiswa')
            ->latest()
            ->paginate(10);

        return view('pemberkasan.index', compact('pemberkasan'));
    }

    /**
     * Tampilkan form untuk membuat pemberkasan baru.
     */
    public function create(): View
    {
        $mahasiswas = Mahasiswa::orderBy('nim')->get();
        return view('pemberkasan.create', compact('mahasiswas'));
    }

    /**
     * Simpan pemberkasan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'form_bimbingan' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'sertifikat' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'laporan_final' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $pemberkasan = Pemberkasan::firstOrNew(['mahasiswa_id' => $request->mahasiswa_id]);

        $data = $request->only('mahasiswa_id');

        if ($request->hasFile('form_bimbingan')) {
            if ($pemberkasan->exists && $pemberkasan->form_bimbingan_path) {
                Storage::disk('public')->delete($pemberkasan->form_bimbingan_path);
            }
            $originalName = $request->file('form_bimbingan')->getClientOriginalName();
            $path = $request->file('form_bimbingan')->storeAs('pemberkasan/form_bimbingan', $originalName, 'public');
            $data['form_bimbingan_path'] = $path;
        }

        if ($request->hasFile('sertifikat')) {
            if ($pemberkasan->exists && $pemberkasan->sertifikat_path) {
                Storage::disk('public')->delete($pemberkasan->sertifikat_path);
            }
            $originalName = $request->file('sertifikat')->getClientOriginalName();
            $path = $request->file('sertifikat')->storeAs('pemberkasan/sertifikat', $originalName, 'public');
            $data['sertifikat_path'] = $path;
        }

        if ($request->hasFile('laporan_final')) {
            if ($pemberkasan->exists && $pemberkasan->laporan_final_path) {
                Storage::disk('public')->delete($pemberkasan->laporan_final_path);
            }
            $originalName = $request->file('laporan_final')->getClientOriginalName();
            $path = $request->file('laporan_final')->storeAs('pemberkasan/laporan_final', $originalName, 'public');
            $data['laporan_final_path'] = $path;
        }

        $pemberkasan->fill($data);

        $pemberkasan->is_lengkap = $pemberkasan->form_bimbingan_path && $pemberkasan->sertifikat_path && $pemberkasan->laporan_final_path;

        $pemberkasan->save();

        return redirect()->route('pemberkasan.index')->with('success', 'Data pemberkasan berhasil disimpan!');
    }


    /**
     * Tampilkan detail pemberkasan.
     */
    public function show(Pemberkasan $pemberkasan): View
    {
        $pemberkasan->load('mahasiswa');
        return view('pemberkasan.show', compact('pemberkasan'));
    }

    /**
     * Tampilkan form untuk mengedit pemberkasan.
     */
    public function edit(Pemberkasan $pemberkasan): View
    {
        $pemberkasan->load('mahasiswa');
        $mahasiswas = Mahasiswa::orderBy('nim')->get();

        return view('pemberkasan.edit', compact('pemberkasan', 'mahasiswas'));
    }

    /**
     * Update data pemberkasan di database.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'mahasiswa_id' => 'required',
        'form_bimbingan' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        'sertifikat' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        'laporan_final' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);

    $pemberkasan = Pemberkasan::findOrFail($id);
    $data = ['mahasiswa_id' => $request->mahasiswa_id];

    // Hapus & simpan ulang FORM BIMBINGAN
    if ($request->hasFile('form_bimbingan')) {
        // hapus file lama jika ada
        if ($pemberkasan->form_bimbingan_path && Storage::disk('public')->exists($pemberkasan->form_bimbingan_path)) {
            Storage::disk('public')->delete($pemberkasan->form_bimbingan_path);
        }

        $originalName = $request->file('form_bimbingan')->getClientOriginalName();
        $path = $request->file('form_bimbingan')->storeAs('pemberkasan/form_bimbingan', $originalName, 'public');
        $data['form_bimbingan_path'] = $path;
    }

    // Hapus & simpan ulang SERTIFIKAT
    if ($request->hasFile('sertifikat')) {
        if ($pemberkasan->sertifikat_path && Storage::disk('public')->exists($pemberkasan->sertifikat_path)) {
            Storage::disk('public')->delete($pemberkasan->sertifikat_path);
        }

        $originalName = $request->file('sertifikat')->getClientOriginalName();
        $path = $request->file('sertifikat')->storeAs('pemberkasan/sertifikat', $originalName, 'public');
        $data['sertifikat_path'] = $path;
    }

    // Hapus & simpan ulang LAPORAN FINAL
    if ($request->hasFile('laporan_final')) {
        if ($pemberkasan->laporan_final_path && Storage::disk('public')->exists($pemberkasan->laporan_final_path)) {
            Storage::disk('public')->delete($pemberkasan->laporan_final_path);
        }

        $originalName = $request->file('laporan_final')->getClientOriginalName();
        $path = $request->file('laporan_final')->storeAs('pemberkasan/laporan_final', $originalName, 'public');
        $data['laporan_final_path'] = $path;
    }

    // Cek kelengkapan baru
    $data['is_lengkap'] = isset($data['form_bimbingan_path']) && isset($data['sertifikat_path']) && isset($data['laporan_final_path']);

    $pemberkasan->update($data);

    return redirect()->route('pemberkasan.show', $pemberkasan->id)->with('success', 'Data pemberkasan berhasil diperbarui!');
}

    /**
     * Hapus data pemberkasan dari database.
     */
    public function destroy(Pemberkasan $pemberkasan): RedirectResponse
    {
        $fileColumns = ['form_bimbingan_path', 'sertifikat_path', 'laporan_final_path'];
        foreach ($fileColumns as $column) {
            if ($pemberkasan->$column) {
                Storage::disk('public')->delete($pemberkasan->$column);
            }
        }

        $pemberkasan->delete();
        return redirect()->route('pemberkasan.index')->with('success', 'Data pemberkasan berhasil dihapus.');
    }
public function createMahasiswa(): View
    {
        // 1. Dapatkan ID mahasiswa yang sedang login.
        // GANTI '1' ini dengan ID mahasiswa yang login sesungguhnya.
        // Contoh di aplikasi nyata: $mahasiswaId = Auth::user()->mahasiswa_id;
        $mahasiswaId = 1; // <-- GANTI INI DENGAN LOGIKA AUTH ANDA

        // 2. Cari data pemberkasan milik mahasiswa tersebut.
        $pemberkasan = Pemberkasan::where('mahasiswa_id', $mahasiswaId)->first();

        // 3. Tampilkan view dan kirim data pemberkasan (jika ada)
        return view('mahasiswa.pemberkasan.upload', compact('pemberkasan'));
    }

    /**
     * Simpan berkas yang di-upload oleh mahasiswa.
     * Logika ini didasarkan pada method store() koordinator Anda yang menggunakan firstOrNew.
     */
    public function storeMahasiswa(Request $request)
    {
        // 1. Validasi file (semua opsional, karena mahasiswa bisa upload satu per satu)
        $request->validate([
            'form_bimbingan' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'sertifikat' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'laporan_final' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        // 2. Dapatkan ID mahasiswa yang sedang login.
        // GANTI '1' ini dengan ID mahasiswa yang login sesungguhnya.
        // Contoh di aplikasi nyata: $mahasiswaId = Auth::user()->mahasiswa_id;
        $mahasiswaId = 1; // <-- GANTI INI DENGAN LOGIKA AUTH ANDA

        // 3. Cari data pemberkasan yang ada, atau buat baru jika belum ada.
        $pemberkasan = Pemberkasan::firstOrNew(['mahasiswa_id' => $mahasiswaId]);

        // 4. Handle Upload File (Logika dari controller Anda sudah bagus)
        // Handle Form Bimbingan
        if ($request->hasFile('form_bimbingan')) {
            if ($pemberkasan->form_bimbingan_path) {
                Storage::disk('public')->delete($pemberkasan->form_bimbingan_path);
            }
            $originalName = $request->file('form_bimbingan')->getClientOriginalName();
            $path = $request->file('form_bimbingan')->storeAs('pemberkasan/form_bimbingan', $originalName, 'public');
            $pemberkasan->form_bimbingan_path = $path;
        }

        // Handle Sertifikat
        if ($request->hasFile('sertifikat')) {
            if ($pemberkasan->sertifikat_path) {
                Storage::disk('public')->delete($pemberkasan->sertifikat_path);
            }
            $originalName = $request->file('sertifikat')->getClientOriginalName();
            $path = $request->file('sertifikat')->storeAs('pemberkasan/sertifikat', $originalName, 'public');
            $pemberkasan->sertifikat_path = $path;
        }

        // Handle Laporan Final
        if ($request->hasFile('laporan_final')) {
            if ($pemberkasan->laporan_final_path) {
                Storage::disk('public')->delete($pemberkasan->laporan_final_path);
            }
            $originalName = $request->file('laporan_final')->getClientOriginalName();
            $path = $request->file('laporan_final')->storeAs('pemberkasan/laporan_final', $originalName, 'public');
            $pemberkasan->laporan_final_path = $path;
        }

        // 5. Cek dan update status kelengkapan secara otomatis
        $pemberkasan->is_lengkap = $pemberkasan->form_bimbingan_path && 
                                  $pemberkasan->sertifikat_path && 
                                  $pemberkasan->laporan_final_path;
        
        $pemberkasan->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => auth()->user()->name . ' mengunggah laporan PKL.',
            'type' => 'laporan_upload',
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil diunggah!');

        
    }

    
}