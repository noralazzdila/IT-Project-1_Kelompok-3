<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataMahasiswa;
use App\Models\TempatPKL;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Services\GoogleSheetService;

class StafController extends Controller
{
    public function index()
    {
        $totalMahasiswa = DataMahasiswa::count();
        $totalDosen = Dosen::count();
        $totalTempatPkl = TempatPKL::count();
        $totalSeminar = Seminar::count();

        return view('staf.index', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalTempatPkl',
            'totalSeminar'
        ));
    }

    //-- Data Mahasiswa Management --//
    public function datamahasiswa_index(Request $request)
    {
        $query = DataMahasiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $mahasiswas = $query->latest()->paginate(10)->withQueryString();
        return view('staf.datamahasiswa.index', compact('mahasiswas'));
    }

    public function datamahasiswa_create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        return view('staf.datamahasiswa.create', compact('dosens'));
    }

    public function datamahasiswa_store(Request $request)
    {
        $request->validate([
            'nim'               => 'required|string|max:20|unique:mahasiswa,nim',
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'prodi'             => 'required|string|max:100',
            'kelas'             => 'required|string|max:50',
            'tahun_angkatan'    => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'dosen_pembimbing'  => 'required|string|max:255',
            'tempat_pkl'        => 'required|string|max:255',
            'status_pkl'        => 'required|in:Belum Mulai,Sedang PKL,Selesai',
            'no_hp'             => 'required|string|max:15',
            'email'             => 'required|email|max:255|unique:mahasiswa,email',
        ]);

        DataMahasiswa::create($request->all());

        return redirect()->route('staf.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function datamahasiswa_show(DataMahasiswa $datamahasiswa)
    {
        return view('staf.datamahasiswa.show', compact('datamahasiswa'));
    }

    public function datamahasiswa_edit(DataMahasiswa $datamahasiswa)
    {
        $dosens = Dosen::orderBy('nama')->get();
        return view('staf.datamahasiswa.edit', compact('datamahasiswa', 'dosens'));
    }

    public function datamahasiswa_update(Request $request, DataMahasiswa $datamahasiswa)
    {
        $request->validate([
            'nim'               => ['required','string','max:20', Rule::unique('mahasiswa')->ignore($datamahasiswa->id)],
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'prodi'             => 'required|string|max:100',
            'kelas'             => 'required|string|max:50',
            'tahun_angkatan'    => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'dosen_pembimbing'  => 'required|string|max:255',
            'tempat_pkl'        => 'required|string|max:255',
            'status_pkl'        => 'required|in:Belum Mulai,Sedang PKL,Selesai',
            'no_hp'             => 'required|string|max:15',
            'email'             => ['required','email','max:255', Rule::unique('mahasiswa')->ignore($datamahasiswa->id)],
        ]);

        $datamahasiswa->update($request->all());

        return redirect()->route('staf.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    public function datamahasiswa_destroy(DataMahasiswa $datamahasiswa)
    {
        $datamahasiswa->delete();

        return redirect()->route('staf.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil dihapus.');
    }

    //-- Tempat PKL Management --//
    public function tempatpkl_index(Request $request)
    {
        $query = TempatPKL::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
        }
        if ($request->has('reputasi_perusahaan') && $request->reputasi_perusahaan != '') {
            $query->where('reputasi_perusahaan', $request->reputasi_perusahaan);
        }
        $tempatpkl = $query->latest()->paginate(10);
        return view('staf.tempatpkl.index', compact('tempatpkl'));
    }

    public function tempatpkl_create()
    {
        return view('staf.tempatpkl.create');
    }

    public function tempatpkl_store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jarak_lokasi' => 'nullable|numeric',
            'reputasi_perusahaan' => 'required|string',
            'fasilitas' => 'required|string',
            'kesesuaian_program' => 'required|string',
            'lingkungan_kerja' => 'required|string',
        ]);
        TempatPKL::create($request->all());
        return redirect()->route('staf.tempatpkl.index')->with('success', 'Data Tempat PKL berhasil ditambahkan.');
    }

    public function tempatpkl_show(TempatPKL $tempatpkl)
    {
        return view('staf.tempatpkl.show', compact('tempatpkl'));
    }

    public function tempatpkl_edit(TempatPKL $tempatpkl)
    {
        return view('staf.tempatpkl.edit', compact('tempatpkl'));
    }

    public function tempatpkl_update(Request $request, TempatPKL $tempatpkl)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jarak_lokasi' => 'nullable|numeric',
            'reputasi_perusahaan' => 'required|string',
            'fasilitas' => 'required|string',
            'kesesuaian_program' => 'required|string',
            'lingkungan_kerja' => 'required|string',
        ]);
        $tempatpkl->update($request->all());
        return redirect()->route('staf.tempatpkl.index')->with('success', 'Data Tempat PKL berhasil diperbarui.');
    }

        public function tempatpkl_destroy(TempatPKL $tempatpkl)
        {
            $tempatpkl->delete();
            return redirect()->route('staf.tempatpkl.index')->with('success', 'Data Tempat PKL berhasil dihapus.');
        }

        //-- Seminar Management --//
        public function seminar_index(Request $request)
        {
            $query = Seminar::query();
            if ($request->filled('search')) {
                $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                      ->orWhere('judul', 'like', '%' . $request->search . '%');
            }
            $seminars = $query->latest()->paginate(10);
            return view('staf.seminar.index', compact('seminars'));
        }

        public function seminar_create()
        {
            return view('staf.seminar.create');
        }

        public function seminar_store(Request $request)
        {
            $request->validate([
                'nama_mahasiswa' => 'required|string|max:255',
                'nim' => 'required|string|max:20',
                'nama_pembimbing' => 'required|string|max:255',
                'nama_penguji' => 'required|string|max:255',
                'judul' => 'required|string',
                'tanggal' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'ruang' => 'required|string|max:100',
            ]);

            Seminar::create($request->all());

            return redirect()->route('staf.seminar.index')->with('success', 'Jadwal Seminar berhasil ditambahkan.');
        }

        public function seminar_show(Seminar $seminar)
        {
            return view('staf.seminar.show', compact('seminar'));
        }

        public function seminar_edit(Seminar $seminar)
        {
            return view('staf.seminar.edit', compact('seminar'));
        }

        public function seminar_update(Request $request, Seminar $seminar)
        {
            $request->validate([
                'nama_mahasiswa' => 'required|string|max:255',
                'nim' => 'required|string|max:20',
                'nama_pembimbing' => 'required|string|max:255',
                'nama_penguji' => 'required|string|max:255',
                'judul' => 'required|string',
                'tanggal' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'ruang' => 'required|string|max:100',
            ]);

            $seminar->update($request->all());

            return redirect()->route('staf.seminar.index')->with('success', 'Jadwal Seminar berhasil diperbarui.');
        }

        public function seminar_destroy(Seminar $seminar)
        {
            $seminar->delete();

            return redirect()->route('staf.seminar.index')->with('success', 'Jadwal Seminar berhasil dihapus.');
        }

        //-- Data Dosen Management --//
        public function datadosen_index(Request $request)
        {
            $query = Dosen::query();
            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%')
                      ->orWhere('nip', 'like', '%' . $request->search . '%');
            }
            $dosens = $query->latest()->paginate(10);
            return view('staf.datadosen.index', compact('dosens'));
        }

        public function datadosen_create()
        {
            return view('staf.datadosen.create');
        }

        public function datadosen_store(Request $request)
        {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|max:50|unique:dosens,nip',
                'email' => 'required|email|unique:dosens,email',
                'prodi' => 'required|string|max:100',
            ]);

            Dosen::create($request->all());

            return redirect()->route('staf.datadosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
        }

        public function datadosen_show(Dosen $datadosen)
        {
            return view('staf.datadosen.show', ['dosen' => $datadosen]);
        }

        public function datadosen_edit(Dosen $datadosen)
        {
            return view('staf.datadosen.edit', ['dosen' => $datadosen]);
        }

        public function datadosen_update(Request $request, Dosen $datadosen)
        {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => ['required','string','max:50', Rule::unique('dosens')->ignore($datadosen->id)],
                'email' => ['required','email', Rule::unique('dosens')->ignore($datadosen->id)],
                'prodi' => 'required|string|max:100',
            ]);

            $datadosen->update($request->all());

            return redirect()->route('staf.datadosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
        }

        public function datadosen_destroy(Dosen $datadosen)
        {
            $datadosen->delete();
            return redirect()->route('staf.datadosen.index')->with('success', 'Data Dosen berhasil dihapus.');
        }

        //-- Nilai Management --//
        public function nilai_index()
        {
        $nilai = Nilai::with('mahasiswa')->latest()->get();
        return view('staf.nilai.index', compact('nilai'));
    }

    public function nilai_create()
    {
        return view('staf.nilai.create');
    }

    public function nilai_store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'ipk' => 'nullable|numeric|min:0|max:4',
        ]);

        $mahasiswa = Mahasiswa::firstOrCreate(
            ['nim' => $request->nim],
            ['nama' => $request->nama]
        );

        Nilai::create($request->except(['nim', 'nama', 'jurusan', 'angkatan']) + ['mahasiswa_id' => $mahasiswa->id]);

        return redirect()->route('staf.nilai.index')->with('success', 'Data nilai berhasil disimpan!');
    }

    public function nilai_show($id)
    {
        $nilai = Nilai::with('mahasiswa')->findOrFail($id);
        $rows = collect();

        if ($nilai->sheet_name) {
            try {
                $sheetService = app(GoogleSheetService::class);
                $values = $sheetService->getSheetData($nilai->sheet_name);

                if (!empty($values)) {
                    $dataRows = array_slice($values, 1);
                    $rows = collect($dataRows)->map(function ($row) {
                        return [
                            'kode'        => $row[1] ?? '',
                            'mata_kuliah' => $row[2] ?? '',
                            'nilai'       => $row[3] ?? '',
                            'am'          => $row[4] ?? '',
                            'sks'         => $row[5] ?? '',
                            'bobot'       => $row[6] ?? '',
                        ];
                    });
                }
            } catch (\Exception $e) {
                Log::error('Gagal mengambil data dari Google Sheet untuk show: ' . $e->getMessage());
            }
        }
        
        return view('staf.nilai.show', compact('nilai', 'rows'));
    }



    public function nilai_edit($id)

    {

        $nilai = Nilai::with('mahasiswa')->findOrFail($id);

        return view('staf.nilai.edit', compact('nilai'));

    }



    public function nilai_update(Request $request, $id)

    {

        $request->validate([

            'nim' => 'required|string|max:20',

            'nama' => 'required|string|max:100',

            'ipk' => 'nullable|numeric|min:0|max:4',

        ]);



        $nilai = Nilai::with('mahasiswa')->findOrFail($id);



        if ($nilai->mahasiswa) {

            $nilai->mahasiswa->update([

                'nim' => $request->nim,

                'nama' => $request->nama,

            ]);

        }



        $nilai->update($request->except(['nim', 'nama', 'jurusan', 'angkatan']));



        return redirect()->route('staf.nilai.index')->with('success', 'Data nilai berhasil diperbarui!');

    }



        public function nilai_destroy($id)



        {



            $nilai = Nilai::findOrFail($id);



            $nilai->delete();



    



            return redirect()->route('staf.nilai.index')->with('success', 'Data nilai berhasil dihapus!');



        }



    



                public function nilai_import_pdf(Request $request)



    



                {



    



                    $request->validate([



    



                        'file_pdf' => 'required|mimes:pdf|max:2048',



    



                    ]);



    



        



    



                    try {



    



                        $file = $request->file('file_pdf');



    



                        



    



                        $pdfPath = $file->store('pdfs', 'public');



    



                        



    



                        $path_to_pdftotext = 'C:\poppler-windows-25.07.0-0\bin\pdftotext.exe';



    



                        



    



                        $text = (new Pdf($path_to_pdftotext))->setPdf($file->getPathname())->text();



    



        



    



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



    



                        



    



                        $sksD = 0;



    



                        $gradeCounts = ['A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0];



    



        



    



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



    



                            'pdf_path' => $pdfPath,



    



                        ];



    



        



    



                        return response()->json($data);

                    } catch (\Exception $e) {



    



                        Log::error('Gagal import PDF: ' . $e->getMessage());



    



                        return response()->json(['error' => 'Gagal memproses file PDF: ' . $e->getMessage()], 500);
                    }
                }
            public function nilai_serve_pdf($id)
            {
                $nilai = Nilai::findOrFail($id);
                $path = $nilai->pdf_path;
                if (!$path || !Storage::disk('public')->exists($path)) {
                    abort(404, 'File PDF tidak ditemukan.');

                }

                return response()->file(Storage::disk('public')->path($path));

            }
        }
