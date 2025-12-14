<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\DataMahasiswa;
use App\Models\Dosen;
use App\Models\Nilai;
use App\Models\Pemberkasan;
use App\Models\Proposal;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Tampilkan semua dosen
    public function index()
    {
        // Data untuk card
        $mahasiswaMemenuhiSyarat = Nilai::where('ipk', '>=', 2.5)
                                          ->where('sks_d', '<=', 6)
                                          ->where('count_e', 0)
                                          ->where('total_sks', '>=', 77)
                                          ->count();
        $proposalDisetujui = Proposal::where('status', 'Disetujui')->count();
        $tempatAktif = DataMahasiswa::where('status_pkl', 'Sedang PKL')->count();
        $seminarBulanIni = Seminar::whereMonth('tanggal', Carbon::now()->month)
                                  ->whereYear('tanggal', Carbon::now()->year)
                                  ->count();

        // Data untuk jadwal seminar
        $seminars = Seminar::orderBy('tanggal', 'asc')
                            ->orderBy('jam_mulai', 'asc')
                            ->take(5)
                            ->get();

        // Data untuk aktivitas terbaru
        $latestBimbingan = Bimbingan::latest()->first();
        $latestProposal = Proposal::latest()->first();
        $latestPemberkasan = Pemberkasan::with('mahasiswa')->latest()->first(); // Eager load
        $latestSeminar = Seminar::latest()->first();

        $aktivitas = [];
        if ($latestBimbingan) {
            $aktivitas[] = [
                'type' => 'bimbingan',
                'desc' => "Bimbingan baru dari {$latestBimbingan->mahasiswa_nama}",
                'timestamp' => $latestBimbingan->created_at
            ];
        }
        if ($latestProposal) {
            $aktivitas[] = [
                'type' => 'proposal',
                'desc' => "Proposal baru berjudul \"{$latestProposal->judul}\" telah diajukan",
                'timestamp' => $latestProposal->created_at
            ];
        }
        if ($latestPemberkasan) {
             $aktivitas[] = [
                'type' => 'pemberkasan',
                'desc' => "Pemberkasan dari {$latestPemberkasan->mahasiswa?->nama} telah diperbarui",
                'timestamp' => $latestPemberkasan->updated_at
            ];
        }
        if ($latestSeminar) {
            $aktivitas[] = [
                'type' => 'seminar',
                'desc' => "Jadwal seminar untuk {$latestSeminar->nama_mahasiswa} telah ditambahkan",
                'timestamp' => $latestSeminar->created_at
            ];
        }

        // Urutkan aktivitas berdasarkan timestamp
        usort($aktivitas, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Ubah timestamp menjadi format 'diffForHumans' untuk view
        foreach ($aktivitas as &$item) {
            $item['time'] = $item['timestamp']->diffForHumans();
            unset($item['timestamp']);
        }
        unset($item); // Hapus referensi terakhir

        return view('dosen.dashboard', compact(
            'mahasiswaMemenuhiSyarat',
            'proposalDisetujui',
            'tempatAktif',
            'seminarBulanIni',
            'seminars',
            'aktivitas'
        ));
    }

    // Form tambah dosen
    public function create()
    {
        return view('dosen.create');
    }

    // Simpan data dosen baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nidn' => 'required|unique:dosens,nidn',
            'email' => 'required|email|unique:dosens,email',
            'jurusan' => 'required|string|max:100',
        ]);

        Dosen::create($request->all());
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    // Lihat detail dosen
    public function show($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.show', compact('dosen'));
    }

    // Form edit dosen
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.edit', compact('dosen'));
    }

    // Update data dosen
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'jurusan' => 'required|string|max:100',
        ]);

        $dosen->update($request->all());
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil diperbarui.');
    }

    // Hapus data dosen
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil dihapus.');
    }
}
