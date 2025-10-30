<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\User;
use App\Models\DataMahasiswa;
use App\Models\Penguji;
use App\Models\Dosen;
use App\Models\SuratPengantar;
use App\Models\Pemberkasan;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class KoorprodiController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all();
        return view('koorprodi.koorprodi', compact('seminars'));
    }

    public function user_index()
    {
        $users = User::all();
        return view('koorprodi.user.index', compact('users'));
    }

    public function user_create()
    {
        return view('koorprodi.user.create');
    }

    public function user_store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'role'       => 'required|string',
            'identifier' => 'nullable|string|max:50', // NIM / NIP
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

        return redirect()->route('koorprodi.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function user_show($id)
    {
        $user = User::findOrFail($id);
        return view('koorprodi.user.show', compact('user'));
    }

    public function user_edit($id)
    {
        $user = User::findOrFail($id);
        return view('koorprodi.user.edit', compact('user'));
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

        return redirect()->route('koorprodi.user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function user_destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('koorprodi.user.index')->with('success', 'User berhasil dihapus!');
    }

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
        return view('koorprodi.datamahasiswa.index', compact('mahasiswas'));
    }

    public function datamahasiswa_create()
    {
        return view('koorprodi.datamahasiswa.create');
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

        return redirect()->route('koorprodi.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function datamahasiswa_show(DataMahasiswa $datamahasiswa)
    {
        return view('koorprodi.datamahasiswa.show', compact('datamahasiswa'));
    }

    public function datamahasiswa_edit(DataMahasiswa $datamahasiswa)
    {
        return view('koorprodi.datamahasiswa.edit', compact('datamahasiswa'));
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

        return redirect()->route('koorprodi.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    public function datamahasiswa_destroy(DataMahasiswa $datamahasiswa)
    {
        $datamahasiswa->delete();

        return redirect()->route('koorprodi.datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil dihapus.');
    }

    public function penguji_index()
    {
        $pengujis = Penguji::latest()->paginate(10);
        return view('koorprodi.penguji.index', compact('pengujis'));
    }

    public function penguji_create()
    {
        return view('koorprodi.penguji.create');
    }

    public function penguji_store(Request $request)
    {
        $request->validate([
            'nama_penguji' => 'required|string|max:255',
            'nip'          => 'required|string|max:20|unique:penguji,nip',
            'email'        => 'required|email|max:255|unique:penguji,email',
            'no_telepon'   => 'required|string|max:15',
            'jabatan'      => 'required|string|max:100',
        ]);

        Penguji::create($request->all());

        return redirect()->route('koorprodi.penguji.index')
                         ->with('success', 'Data Penguji berhasil ditambahkan.');
    }

    public function penguji_show(Penguji $penguji)
    {
        return view('koorprodi.penguji.show', compact('penguji'));
    }

    public function penguji_edit(Penguji $penguji)
    {
        return view('koorprodi.penguji.edit', compact('penguji'));
    }

    public function penguji_update(Request $request, Penguji $penguji)
    {
        $request->validate([
            'nama_penguji' => 'required|string|max:255',
            'nip'          => ['required', 'string', 'max:20', Rule::unique('penguji')->ignore($penguji->id)],
            'email'        => ['required', 'email', 'max:255', Rule::unique('penguji')->ignore($penguji->id)],
            'no_telepon'   => 'required|string|max:15',
            'jabatan'      => 'required|string|max:100',
        ]);

        $penguji->update($request->all());

        return redirect()->route('koorprodi.penguji.index')
                         ->with('success', 'Data Penguji berhasil diperbarui.');
    }

    public function penguji_destroy(Penguji $penguji)
    {
        $penguji->delete();

        return redirect()->route('koorprodi.penguji.index')
                         ->with('success', 'Data Penguji berhasil dihapus.');
    }



    public function proposal_index(Request $request)
    {
        $query = Proposal::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                  ->orWhere('judul_proposal', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $proposals = $query->latest()->paginate(10);

        return view('koorprodi.proposal.index', compact('proposals'));
    }

    public function proposal_create()
    {
        return view('koorprodi.proposal.create');
    }

    public function proposal_store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20|unique:proposals,nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf|max:5120', // Max 5MB
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Disetujui', 'Ditolak'])],
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_proposal')) {
            $filePath = $request->file('file_proposal')->store('public/proposals');
            $validatedData['file_proposal'] = str_replace('public/', '', $filePath);
        }

        Proposal::create($validatedData);

        return redirect()->route('koorprodi.proposal.index')->with('success', 'Proposal PKL berhasil ditambahkan.');
    }

    public function proposal_show(Proposal $proposal)
    {
        return view('koorprodi.proposal.show', compact('proposal'));
    }

    public function proposal_edit(Proposal $proposal)
    {
        return view('koorprodi.proposal.edit', compact('proposal'));
    }

    public function proposal_update(Request $request, Proposal $proposal)
    {
        $validatedData = $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('proposals')->ignore($proposal->id)],
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'file_proposal' => 'nullable|file|mimes:pdf|max:5120', // Opsional saat update
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Disetujui', 'Ditolak'])],
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal)) {
                Storage::delete('public/' . $proposal->file_proposal);
            }
            
            $filePath = $request->file('file_proposal')->store('public/proposals');
            $validatedData['file_proposal'] = str_replace('public/', '', $filePath);
        }

        $proposal->update($validatedData);

        return redirect()->route('koorprodi.proposal.index')->with('success', 'Proposal PKL berhasil diperbarui.');
    }

    public function proposal_destroy(Proposal $proposal)
    {
        if ($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal)) {
            Storage::delete('public/' . $proposal->file_proposal);
        }
        
        $proposal->delete();

        return redirect()->route('koorprodi.proposal.index')->with('success', 'Proposal PKL berhasil dihapus.');
    }

    public function datadosen_index(Request $request)
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
        return view('koorprodi.datadosen.index', compact('dosens'));
    }

    public function datadosen_create()
    {
        return view('koorprodi.datadosen.create');
    }

    public function datadosen_store(Request $request)
    {
        $request->validate([
            'nip'              => 'required|string|max:20|unique:dosens,nip',
            'nama'              => 'required|string|max:255',
            'jabatan'             => 'required|string|max:100',
        ]);

        Dosen::create($request->all());

        return redirect()->route('koorprodi.datadosen.index')
                         ->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    public function datadosen_show(Dosen $datadosen)
    {
        return view('koorprodi.datadosen.show', compact('datadosen'));
    }

    public function datadosen_edit(Dosen $datadosen)
    {
        return view('koorprodi.datadosen.edit', compact('datadosen'));
    }

    public function datadosen_update(Request $request, Dosen $datadosen)
    {
        $request->validate([
            'nip'              => ['required','string','max:20', Rule::unique('dosens')->ignore($datadosen->id)],
            'nama'              => 'required|string|max:255',
            'jabatan'             => 'required|string|max:100',
        ]);

        $datadosen->update($request->all());

        return redirect()->route('koorprodi.datadosen.index')
                         ->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function datadosen_destroy(Dosen $datadosen)
    {
        $datadosen->delete();

        return redirect()->route('koorprodi.datadosen.index')
                         ->with('success', 'Data Dosen berhasil dihapus.');
    }

    public function seminar_index()
    {
        $seminars = Seminar::latest()->paginate(10);
        return view('koorprodi.seminar.index', compact('seminars'));
    }

    public function suratpengantar_index()
    {
        $suratpengantars = SuratPengantar::latest()->paginate(10);
        return view('koorprodi.suratpengantar.index', compact('suratpengantars'));
    }

    public function pemberkasan_index()
    {
        $pemberkasans = Pemberkasan::latest()->paginate(10);
        return view('koorprodi.pemberkasan.index', compact('pemberkasans'));
    }
}