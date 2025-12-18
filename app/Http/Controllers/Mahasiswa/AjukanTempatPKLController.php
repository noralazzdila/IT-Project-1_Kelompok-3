<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Notifications\NotifikasiPKL;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanPKL;
use App\Models\Mahasiswa; // Pastikan model Mahasiswa diimpor
use App\Models\Nilai; // Pastikan model Nilai diimpor
use Illuminate\Support\Facades\Log; // Untuk logging error
use Illuminate\Support\Facades\Storage;
use App\Models\SuratPengantar;
class AjukanTempatPKLController extends Controller
{
    /**
     * Tampilkan daftar pengajuan mahasiswa
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_id', Auth::id())->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        $pengajuan = PengajuanPKL::where('mahasiswa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.tempatpkl.lihattempatpkl', compact('pengajuan'));
    }

    /**
     * Tampilkan halaman ajukan tempat PKL (multi-step)
     */
    public function create()
    {
        // Ambil user dan data mahasiswa yang sedang login
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'FATAL: Akun Anda tidak terhubung dengan data mahasiswa. Harap segera hubungi administrator.');
        }

        // Ambil pengajuan PKL yang ada untuk mahasiswa ini
        $pengajuan = PengajuanPKL::where('mahasiswa_id', $user->id)->first();
        $nilai = $mahasiswa->nilai()->latest()->first();

        // Siapkan data syarat jika ada nilai
        $requirements = null;
        $isEligible = false; // Default
        if ($nilai) {
            $requirements = [
                'IPK'         => ['required' => '>= 2.50', 'actual' => number_format($nilai->ipk, 2), 'status' => $nilai->ipk >= 2.5],
                'Total SKS'   => ['required' => '>= 77', 'actual' => $nilai->total_sks, 'status' => $nilai->total_sks >= 77],
                'SKS Nilai D' => ['required' => '<= 6', 'actual' => $nilai->sks_d, 'status' => $nilai->sks_d <= 6],
                'Nilai E'     => ['required' => '= 0', 'actual' => $nilai->count_e, 'status' => $nilai->count_e == 0],
            ];
            $isEligible = ($nilai->ipk >= 2.5 && $nilai->total_sks >= 77 && $nilai->sks_d <= 6 && $nilai->count_e == 0);
        }

        return view('mahasiswa.tempatpkl.ajukantempatpkl', compact('pengajuan', 'requirements', 'isEligible'));
    }

    /**
     * Upload PDF, proses, validasi, dan simpan nilai mahasiswa
     */
    public function uploadPdf(Request $request)
    {
        $request->validate(['pdf' => 'required|mimes:pdf|max:2048']);

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan.'], 404);
        }

        try {
            // Hapus file PDF lama jika ada
            $existingPengajuan = PengajuanPKL::where('mahasiswa_id', $user->id)->first();
            if ($existingPengajuan && $existingPengajuan->pdf_path) {
                $oldFilePath = storage_path('app/public/' . $existingPengajuan->pdf_path);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('pdf');
            $pdfPath = $file->store('pdf_transkip', 'public');
            
            // Path ke pdftotext
            $path_to_pdftotext = 'C:\poppler-windows-25.07.0-0\bin\pdftotext.exe';
            if (!file_exists($path_to_pdftotext)) {
                throw new \Exception("Library Poppler (pdftotext.exe) tidak ditemukan.");
            }

            $text = (new \Spatie\PdfToText\Pdf($path_to_pdftotext))->setPdf($file->getPathname())->text();

            // Ekstrak data dari teks PDF (Ini data asli dari file)
            $data = $this->extractDataFromPdfText($text);
            $data['pdf_path'] = $pdfPath;

            // Simpan atau update data nilai
            $nilai = Nilai::updateOrCreate(
                ['mahasiswa_id' => $mahasiswa->id],
                $data
            );

            // Lakukan validasi syarat PKL
            $isEligible = ($nilai->ipk >= 2.5 && $nilai->total_sks >= 77 && $nilai->sks_d <= 6 && $nilai->count_e == 0);

            // Update PengajuanPKL record with pdf_path. Do NOT set application status here.
            // If PengajuanPKL doesn't exist, create it with a default status for the application lifecycle.
            PengajuanPKL::firstOrCreate(
                ['mahasiswa_id' => $user->id],
                ['pdf_path' => $pdfPath, 'status' => 'belum_diajukan'] // Default status for a new application
            )->update(['pdf_path' => $pdfPath]); // Update pdf_path if it already exists

            if (!$isEligible) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi Gagal: Anda tidak memenuhi syarat untuk mengajukan PKL. Silakan periksa detail di bawah ini dan unggah transkrip yang telah diperbarui jika ada.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'PDF berhasil divalidasi! Anda sekarang dapat mengajukan tempat PKL.',
                'isEligible' => true // Return eligibility status to frontend
            ]);

        } catch (\Exception $e) {
            Log::error("PDF Upload/Processing failed for user {$user->id}: " . $e->getMessage());
            return response()->json(['message' => 'Gagal memproses file PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper function untuk ekstrak data dari text PDF.
     */
    private function extractDataFromPdfText(string $text): array
    {
        $dataMahasiswa = [];
        $patterns = [
            'nama'      => '/Nama\s*:\s*(.*)/',
            'nim'       => '/NIM\s*:\s*(\d+)/',
            'angkatan'  => '/Tahun Masuk\s*:\s*(\d{4})/',
            'ipk'       => '/(?:Index Prestasi Kumulatif \$IPK\$|IPK)\s*:\s*([\d,.]+)/i',
            'total_sks' => '/(?:Jumlah SKS Yang Diambil|Jumlah SKS)\s*:\s*(\d+)/i'
        ];

        foreach ($patterns as $key => $pattern) {
            $dataMahasiswa[$key] = preg_match($pattern, $text, $matches) ? trim($matches[1]) : null;
        }

        $sksD = 0;
        $gradeCounts = ['A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        $coursePattern = '/^\d+\s+[A-Z0-9]+\s+(.*?)\s+([A-Z+]{1,2})\s+[\d.]+\s+(\d+)\s+[\d.]+/m';
        
        if (preg_match_all($coursePattern, $text, $courseLines, PREG_SET_ORDER)) {
            foreach ($courseLines as $line) {
                $grade = trim($line[2]);
                $sks = (int) $line[3];
                if (isset($gradeCounts[$grade])) $gradeCounts[$grade]++;
                if ($grade === 'D') $sksD += $sks;
            }
        }

        $ipkValue = $dataMahasiswa['ipk'] ? str_replace(',', '.', $dataMahasiswa['ipk']) : 0;
        
        return [
            'nim' => $dataMahasiswa['nim'],
            'nama' => $dataMahasiswa['nama'],
            'angkatan' => $dataMahasiswa['angkatan'],
            'ipk' => (float) $ipkValue,
            'total_sks' => (int) $dataMahasiswa['total_sks'],
            'sks_d' => $sksD,
            'count_a' => $gradeCounts['A'],
            'count_b_plus' => $gradeCounts['B+'],
            'count_b' => $gradeCounts['B'],
            'count_c_plus' => $gradeCounts['C+'],
            'count_c' => $gradeCounts['C'],
            'count_d' => $gradeCounts['D'],
            'count_e' => $gradeCounts['E'],
        ];
    }

    /**
     * Simpan data tempat PKL (tahap 2)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input sesuai dengan field SuratPengantar
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255', // Akan dipetakan ke tempat_pkl di SuratPengantar
            'bidang'          => 'nullable|string|max:255', // Tidak ada di SuratPengantar, akan diabaikan atau digunakan di tempat lain jika diperlukan
            'alamat'          => 'required|string', // Akan dipetakan ke alamat_perusahaan di SuratPengantar
            'nama_pic'        => 'nullable|string|max:255', // Tidak ada di SuratPengantar
            'telepon_pic'     => 'nullable|string|max:20', // Tidak ada di SuratPengantar
        ]);

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // 2. Cari Pengajuan PKL yang sudah ada untuk mendapatkan pdf_path transkrip
        $pengajuan = PengajuanPKL::where('mahasiswa_id', $user->id)->first();

        if (!$pengajuan || !$pengajuan->pdf_path) {
            return redirect()->back()->with('error', 'Anda harus mengupload transkrip nilai terlebih dahulu.');
        }

        // 3. Buat entri baru di tabel SuratPengantar
        SuratPengantar::create([
            'nim'               => $mahasiswa->nim,
            'nama_mahasiswa'    => $mahasiswa->nama,
            'prodi'             => $mahasiswa->prodi ?? 'Teknologi Informasi', // Ambil dari mahasiswa atau default
            'tempat_pkl'        => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat,
            'tanggal_pengajuan' => now(),
            'status'            => 'menunggu_verifikasi', // Status awal surat pengantar
            'file_surat'        => $pengajuan->pdf_path, // Menggunakan PDF transkrip sebagai 'file_surat' awal
        ]);

        // 4. Update status PengajuanPKL
        $pengajuan->update(['status' => 'surat_diajukan']); // Update status pengajuan PKL

        // 5. Catat aktivitas
        ActivityLog::create([
            'user_id'  => $user->id,
            'activity' => $user->name . ' mengajukan surat pengantar PKL untuk ' . $request->nama_perusahaan,
            'type'     => 'pengajuan_surat_pengantar',
        ]);

        // 6. Kirim notifikasi ke Koordinator
        $koorPkl = User::where('role', 'koor_pkl')->first();
        if ($koorPkl) {
            $koorPkl->notify(new NotifikasiPKL(
                'Pengajuan Surat Pengantar PKL Baru',
                $user->name . ' telah mengajukan surat pengantar PKL untuk ' . $request->nama_perusahaan . '.',
                route('koor.dashboard') // Sesuaikan route dashboard koor
            ));
        }

        return redirect()->route('dashboard.mahasiswa')->with('success', 'Pengajuan surat pengantar PKL berhasil dikirim!');
    }
}