<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\DataMahasiswa;

use App\Models\TempatPKL;

use App\Models\Nilai;

use App\Models\Mahasiswa;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;



class StafController extends Controller

{

    public function index()

    {

        return view('staf.index');

    }



    //-- User Management --//

    public function user_index()

    {

        $users = User::all();

        return view('staf.user.index', compact('users'));

    }



    public function user_create()

    {

        return view('staf.user.create');

    }



    public function user_store(Request $request)

    {

        $request->validate([

            'name'       => 'required|string|max:100',

            'email'      => 'required|email|unique:users,email',

            'password'   => 'required|min:6|confirmed',

            'role'       => 'required|string',

            'identifier' => 'nullable|string|max:50',

            'status'     => 'required|string|in:aktif,nonaktif',

        ]);



        User::create([

            'name'       => $request->name,

            'email'      => $request->email,

            'password'   => Hash::make($request->password),

            'role'       => $request->role,

            'identifier' => $request->identifier,

            'status'     => $request->status,

        ]);



        return redirect()->route('staf.user.index')->with('success', 'User berhasil ditambahkan!');

    }



    public function user_show($id)

    {

        $user = User::findOrFail($id);

        return view('staf.user.show', compact('user'));

    }



    public function user_edit($id)

    {

        $user = User::findOrFail($id);

        return view('staf.user.edit', compact('user'));

    }



    public function user_update(Request $request, $id)

    {

        $user = User::findOrFail($id);



        $request->validate([

            'name'       => 'required|string|max:100',

            'email'      => 'required|email|unique:users,email,' . $user->id,

            'password'   => 'nullable|min:6|confirmed',

            'role'       => 'required|string',

            'identifier' => 'nullable|string|max:50',

            'status'     => 'required|string|in:aktif,nonaktif',

        ]);



        $user->update([

            'name'       => $request->name,

            'email'      => $request->email,

            'role'       => $request->role,

            'identifier' => $request->identifier,

            'status'     => $request->status,

        ]);



        if ($request->filled('password')) {

            $user->update([

                'password' => Hash::make($request->password),

            ]);

        }



        return redirect()->route('staf.user.index')->with('success', 'Data user berhasil diperbarui!');

    }



    public function user_destroy($id)

    {

        $user = User::findOrFail($id);

        $user->delete();



        return redirect()->route('staf.user.index')->with('success', 'User berhasil dihapus!');

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

        return view('staf.datamahasiswa.create');

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

        return view('staf.datamahasiswa.edit', compact('datamahasiswa'));

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

}


