<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPKL;
use App\Models\Mahasiswa;
use App\Models\PengajuanPKL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            // Redirect if the user has no associated student data, which is a critical error.
            return redirect()->route('dashboard')->with('error', 'FATAL: Akun Anda tidak terhubung dengan data mahasiswa. Harap segera hubungi administrator.');
        }

        // Ambil pengajuan PKL yang ada untuk mahasiswa ini
        $pengajuan = PengajuanPKL::where('mahasiswa_id', $user->id)->first();
        $nilai = $mahasiswa->nilai()->latest()->first();

        // Siapkan data syarat jika ada nilai
        $requirements = null;
        if ($nilai) {
            $requirements = [
                'IPK'         => ['required' => '>= 2.50', 'actual' => number_format($nilai->ipk, 2), 'status' => $nilai->ipk >= 2.5],
                'Total SKS'   => ['required' => '>= 77', 'actual' => $nilai->total_sks, 'status' => $nilai->total_sks >= 77],
                'SKS Nilai D' => ['required' => '<= 6', 'actual' => $nilai->sks_d, 'status' => $nilai->sks_d <= 6],
                'Nilai E'     => ['required' => '= 0', 'actual' => $nilai->count_e, 'status' => $nilai->count_e == 0],
            ];
        }

        return view('mahasiswa.tempatpkl.ajukantempatpkl', compact('pengajuan', 'requirements'));
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
            $file = $request->file('pdf');
            $pdfPath = $file->store('pdf_transkip', 'public');
            
            // Path ke pdftotext, pastikan Poppler terinstall
            $path_to_pdftotext = 'C:\poppler-windows-25.07.0-0\bin\pdftotext.exe';
            if (!file_exists($path_to_pdftotext)) {
                throw new \Exception("Library Poppler (pdftotext.exe) tidak ditemukan.");
            }

            $text = (new \Spatie\PdfToText\Pdf($path_to_pdftotext))->setPdf($file->getPathname())->text();

            // Ekstrak data dari teks PDF
            $data = $this->extractDataFromPdfText($text);
            $data['pdf_path'] = $pdfPath;

            // Simpan atau update data nilai
            $nilai = Nilai::updateOrCreate(
                ['mahasiswa_id' => $mahasiswa->id],
                $data
            );

            // Lakukan validasi syarat PKL
            $isEligible = ($nilai->ipk >= 2.5 && $nilai->total_sks >= 77 && $nilai->sks_d <= 6 && $nilai->count_e == 0);
            $status = $isEligible ? 'diterima' : 'ditolak';

            // Simpan atau update status pengajuan
            PengajuanPKL::updateOrCreate(
                ['mahasiswa_id' => $user->id],
                ['pdf_path' => $pdfPath, 'status' => $status]
            );

            if (!$isEligible) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi Gagal: Anda tidak memenuhi syarat untuk mengajukan PKL. Silakan periksa detail di bawah ini dan unggah transkrip yang telah diperbarui jika ada.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'PDF berhasil divalidasi! Anda sekarang dapat mengajukan tempat PKL.',
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
            'ipk'       => '/(?:Index Prestasi Kumulatif \(IPK\)|IPK)\s*:\s*([\d,.]+)/i',
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
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pic' => 'nullable|string|max:255',
            'telepon_pic' => 'nullable|string|max:20',
            'pdf_path' => 'required|string'
        ]);

        $mahasiswa = Mahasiswa::where('mahasiswa_id', Auth::id())->first();

        // Update pengajuan mahasiswa tahap 2
        $pengajuan = PengajuanPKL::updateOrCreate(
            ['mahasiswa_id' => Auth::id()],
            [
                'nama_perusahaan' => $request->nama_perusahaan,
                'bidang' => $request->bidang,
                'alamat' => $request->alamat,
                'nama_pic' => $request->nama_pic,
                'telepon_pic' => $request->telepon_pic,
                'pdf_path' => $request->pdf_path,
                'status' => 'diproses'
            ]
        );

        return redirect()->route('tempatpkl.ajukantempatpkl')
            ->with('success', 'Pengajuan tempat PKL berhasil dikirim!');
    }
}