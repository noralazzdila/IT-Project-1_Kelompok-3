<?php

namespace App\Http\Controllers;

use Spatie\PdfToText\Pdf;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;
use Exception;

class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('mahasiswa')->latest()->get(); // Tampilkan data terbaru
        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        return view('nilai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'count_a' => 'nullable|integer|min:0',
            'count_b_plus' => 'nullable|integer|min:0',
            'count_b' => 'nullable|integer|min:0',
            'count_c_plus' => 'nullable|integer|min:0',
            'count_c' => 'nullable|integer|min:0',
            'count_d' => 'nullable|integer|min:0',
            'sks_d' => 'nullable|integer|min:0', // 👈 Tambahkan validasi
            'count_e' => 'nullable|integer|min:0',
            'total_sks' => 'nullable|integer|min:0',
            'sheet_name' => 'nullable|string|max:255',
            'pdf_path' => 'nullable|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::firstOrCreate(
            ['nim' => $request->nim],
            [
                'nama' => $request->nama,
            ]
        );

        if (Nilai::where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return redirect()->back()->withErrors(['nim' => 'Nilai untuk NIM ini sudah ada.'])->withInput();
        }

        Nilai::create([
            'mahasiswa_id' => $mahasiswa->id,
            'ipk' => $request->ipk,
            'count_a' => $request->count_a,
            'count_b_plus' => $request->count_b_plus,
            'count_b' => $request->count_b,
            'count_c_plus' => $request->count_c_plus,
            'count_c' => $request->count_c,
            'count_d' => $request->count_d,
            'sks_d' => $request->sks_d, // 👈 Tambahkan data
            'count_e' => $request->count_e,
            'total_sks' => $request->total_sks,
            'sheet_name' => $request->sheet_name,
            'pdf_path' => $request->pdf_path,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Data mahasiswa & nilai berhasil disimpan!');
    }

    public function import(Request $request, GoogleSheetService $sheetService)
    {
        try {
            $sheetName = $request->sheet_name;

            if (!$sheetName) {
                return response()->json(['error' => 'Nama sheet tidak boleh kosong.'], 400);
            }

            $rows = $sheetService->getSheetData($sheetName);

            if (empty($rows) || count($rows) < 2) {
                return response()->json(['error' => 'Sheet kosong atau tidak berisi data.'], 404);
            }

            $dataRows = array_slice($rows, 1);

            $totalSks = 0;
            $totalBobot = 0;
            $sksD = 0; // 👈 Variabel untuk hitung SKS nilai D
            $counts = ['A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0];

            foreach ($dataRows as $row) {
                if (count($row) < 6) continue;

                $nilaiHuruf = strtoupper(trim($row[3] ?? ''));
                $am = (float)($row[4] ?? 0);
                $sks = (int)($row[5] ?? 0);

                if ($sks === 0) continue;

                $totalBobot += ($am * $sks);
                $totalSks += $sks;

                if (isset($counts[$nilaiHuruf])) {
                    $counts[$nilaiHuruf]++;
                }
                
                // 👈 Logika untuk menghitung total SKS nilai D
                if ($nilaiHuruf === 'D') {
                    $sksD += $sks;
                }
            }

            $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;
            
            // Logika untuk ambil info mahasiswa dari sheet (diasumsikan dari baris pertama data)
            $firstDataRow = $dataRows[0] ?? [];
            $nim = $firstDataRow[0] ?? 'NIM_TIDAK_DITEMUKAN'; // Ganti sesuai kolom
            $nama = $firstDataRow[1] ?? 'NAMA_TIDAK_DITEMUKAN'; // Ganti sesuai kolom
            
            $data = [
                'nim' => $nim,
                'nama' => $nama,
                'ipk' => $ipk,
                'count_a' => $counts['A'],
                'count_b_plus' => $counts['B+'],
                'count_b' => $counts['B'],
                'count_c_plus' => $counts['C+'],
                'count_c' => $counts['C'],
                'count_d' => $counts['D'],
                'sks_d' => $sksD, // 👈 Kirim data SKS D
                'count_e' => $counts['E'],
                'total_sks' => $totalSks,
                'sheet_name' => $sheetName,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Gagal import Google Sheet: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengimport data: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $nilai = Nilai::with('mahasiswa')->findOrFail($id);
        $rows = collect();

        if ($nilai->sheet_name) {
            try {
                // Menggunakan service container untuk memanggil service, ini praktik yang lebih baik
                $sheetService = app(\App\Services\GoogleSheetService::class);

                // PERBAIKAN: Memanggil metode yang benar `getSheetData()`
                $values = $sheetService->getSheetData($nilai->sheet_name);

                if (!empty($values)) {
                    // Menghapus baris header (baris pertama) agar konsisten dengan fungsi import
                    $dataRows = array_slice($values, 1);

                    $rows = collect($dataRows)->map(function ($row) {
                        // Sesuaikan indeks array dengan struktur kolom di Google Sheet Anda
                        return [
                            'kode'        => $row[1] ?? '', // Kolom B
                            'mata_kuliah' => $row[2] ?? '', // Kolom C
                            'nilai'       => $row[3] ?? '', // Kolom D
                            'am'          => $row[4] ?? '', // Kolom E
                            'sks'         => $row[5] ?? '', // Kolom F
                            'bobot'       => $row[6] ?? '', // Kolom G
                        ];
                    });
                }
            } catch (\Exception $e) {
                Log::error('Gagal mengambil data dari Google Sheet untuk show: ' . $e->getMessage());
                // Halaman akan tetap ditampilkan meskipun gagal mengambil data sheet
            }
        }
        
        return view('nilai.show', compact('nilai', 'rows'));
    }

    public function edit($id)
    {
        $nilai = Nilai::with('mahasiswa')->findOrFail($id);
        return view('nilai.edit', compact('nilai'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'count_a' => 'nullable|integer|min:0',
            'count_b_plus' => 'nullable|integer|min:0',
            'count_b' => 'nullable|integer|min:0',
            'count_c_plus' => 'nullable|integer|min:0',
            'count_c' => 'nullable|integer|min:0',
            'count_d' => 'nullable|integer|min:0',
            'sks_d' => 'nullable|integer|min:0', // 👈 Tambahkan validasi
            'count_e' => 'nullable|integer|min:0',
            'total_sks' => 'nullable|integer|min:0',
        ]);

        $nilai = Nilai::with('mahasiswa')->findOrFail($id);

        if ($nilai->mahasiswa) {
            $nilai->mahasiswa->update([
                'nim' => $request->nim,
                'nama' => $request->nama,
            ]);
        }

        $nilai->update([
            'ipk' => $request->ipk ?? 0,
            'count_a' => $request->count_a ?? 0,
            'count_b_plus' => $request->count_b_plus ?? 0,
            'count_b' => $request->count_b ?? 0,
            'count_c_plus' => $request->count_c_plus ?? 0,
            'count_c' => $request->count_c ?? 0,
            'count_d' => $request->count_d ?? 0,
            'sks_d' => $request->sks_d ?? 0, // 👈 Tambahkan data
            'count_e' => $request->count_e ?? 0,
            'total_sks' => $request->total_sks ?? 0,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Data mahasiswa & nilai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();
        

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus!');
    }

 public function importPdf(Request $request)
    {
        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        try {
            $file = $request->file('file_pdf');
            
            // Simpan file PDF yang diupload
            $pdfPath = $file->store('pdfs', 'public');
            
            // PERBAIKAN: Hapus fungsi config() dan langsung tulis path sebagai string
            $path_to_pdftotext = 'C:\poppler-windows-25.07.0-0\bin\pdftotext.exe';
            
            // Pastikan path ini sesuai dengan lokasi di komputer Anda
            $text = (new Pdf($path_to_pdftotext))->setPdf($file->getPathname())->text();

            // 1. Ekstrak data utama menggunakan Regex
            $dataMahasiswa = [];
            $patterns = [
                'nama'      => '/Nama\s*:\s*(.*)/',
                'nim'       => '/NIM\s*:\s*(\d+)/',
                'angkatan'  => '/Tahun Masuk\s*:\s*(\d{4})/',
                'ipk'       => '/(?:Index Prestasi Kumulatif \(IPK\)|IPK)\s*:\s*([\d,.]+)/i',
                'total_sks' => '/(?:Jumlah SKS Yang Diambil|Jumlah SKS)\s*:\s*(\d+)/i'
            ];

            foreach ($patterns as $key => $pattern) {
                if (preg_match($pattern, $text, $matches)) {
                    $dataMahasiswa[$key] = trim($matches[1]);
                } else {
                    $dataMahasiswa[$key] = null;
                }
            }
            
            // 2. Ekstrak Tabel Nilai dan hitung jumlah nilai & SKS D
            $sksD = 0;
            $gradeCounts = ['A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0];

            // Pola Regex untuk menangkap baris mata kuliah
            $coursePattern = '/^\d+\s+[A-Z0-9]+\s+(.*?)\s+([A-Z+]{1,2})\s+[\d.]+\s+(\d+)\s+[\d.]+/m';
            if (preg_match_all($coursePattern, $text, $courseLines, PREG_SET_ORDER)) {
                foreach ($courseLines as $line) {
                    $grade = trim($line[2]);
                    $sks = (int) $line[3];
                    
                    if (isset($gradeCounts[$grade])) {
                        $gradeCounts[$grade]++;
                    }
                    if ($grade === 'D') {
                        $sksD += $sks;
                    }
                }
            }

            // 3. Gabungkan semua data menjadi satu format JSON yang konsisten
            $ipkValue = $dataMahasiswa['ipk'] ? str_replace(',', '.', $dataMahasiswa['ipk']) : null;
            $data = [
                'nim' => $dataMahasiswa['nim'],
                'nama' => $dataMahasiswa['nama'],
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => $dataMahasiswa['angkatan'],
                'ipk' => (float) $ipkValue,
                'count_a' => $gradeCounts['A'],
                'count_b_plus' => $gradeCounts['B+'],
                'count_b' => $gradeCounts['B'],
                'count_c_plus' => $gradeCounts['C+'],
                'count_c' => $gradeCounts['C'],
                'count_d' => $gradeCounts['D'],
                'sks_d' => $sksD,
                'count_e' => $gradeCounts['E'],
                'total_sks' => (int) $dataMahasiswa['total_sks'],
                'sheet_name' => 'Imported from: ' . $file->getClientOriginalName(),
                'pdf_path' => $pdfPath, // Tambahkan path PDF ke response
            ];

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error('Gagal import PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses file PDF: ' . $e->getMessage()], 500);
        }
    }
}