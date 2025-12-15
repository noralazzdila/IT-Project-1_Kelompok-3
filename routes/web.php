<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\KoorPklController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\PengujiController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\TempatPKLController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\PemberkasanController;
use App\Http\Controllers\KoorprodiController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\Dosen\UserDosenController;
use App\Http\Controllers\Dosen\DataMahasiswaController as DosenDataMahasiswaController;
use App\Http\Controllers\Dosen\NilaiDosenController;
use App\Http\Controllers\Dosen\DosenDataDosenController;
use App\Http\Controllers\Dosen\BimbinganDosenController;
use App\Http\Controllers\Dosen\PengujiDosenController;
use App\Http\Controllers\Dosen\PemberkasanDosenController;
use App\Http\Controllers\Dosen\ProposalDosenController;
use App\Http\Controllers\Dosen\SeminarDosenController;
use App\Http\Controllers\Dosen\SuratPengantarDosenController;
use App\Http\Controllers\Mahasiswa\LihatDetailIpkController;
use App\Http\Controllers\Mahasiswa\LihatSemuaTempatPKLController;
use App\Http\Controllers\Mahasiswa\ProfilController;
use App\Http\Controllers\Mahasiswa\PengaturanController;
use App\Http\Controllers\Mahasiswa\PreferensiController;
use App\Http\Controllers\Mahasiswa\MahasiswaDosenController;
use App\Http\Controllers\Mahasiswa\BimbinganController as MahasiswaBimbinganController;
use App\Http\Controllers\TPKController;
use App\Http\Controllers\Mahasiswa\TempatPKLController as MahasiswaTempatPKLController;
use App\Http\Controllers\Mahasiswa\AjukanTempatPKLController;
use App\Http\Controllers\Mahasiswa\UploadProposalController;
use App\Http\Controllers\Mahasiswa\PemberkasanMahasiswaController;
use App\Http\Controllers\Mahasiswa\JadwalSeminarController;
use Illuminate\Support\Facades\Mail;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/mahasiswa/tempat-pkl-terbaik', [TPKController::class, 'hitung']);
/*
|--------------------------------------------------------------------------
| Rute untuk Tamu (Guest)
|--------------------------------------------------------------------------
| Rute-rute ini hanya bisa diakses oleh pengguna yang BELUM LOGIN.
*/
Route::middleware('guest')->group(function () {
    // Halaman default, arahkan ke login
    Route::get('/', fn() => view('auth.login'));

    // Autentikasi Biasa
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('check_role_registration');

    // Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    
    // Login dengan Google
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| Rute Terproteksi (Authenticated)
|--------------------------------------------------------------------------
| Rute-rute ini HANYA bisa diakses oleh pengguna yang SUDAH LOGIN.
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/notifikasi/kirim', [DashboardController::class, 'kirimNotifikasiSemuaRole'])->name('dashboard.notifikasi.kirim');
    Route::post('/dashboard/test-notifikasi',[DashboardController::class, 'testNotifikasiDashboard'])->name('dashboard.test.notifikasi');
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'index'])->name('dashboard.mahasiswa');
    Route::get('/koor-pkl/dashboard', [KoorPklController::class, 'index'])->name('koor.dashboard');
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');

    // Resource Controllers (CRUD)
    Route::resource('proposal', ProposalController::class);
    Route::get('/proposal/{proposal}/file', [ProposalController::class, 'file'])->name('proposal.file');
    Route::resource('tempatpkl', TempatPKLController::class);
    Route::resource('penguji', PengujiController::class);
    Route::resource('seminar', SeminarController::class);
    Route::resource('datamahasiswa', DataMahasiswaController::class);
    Route::resource('bimbingan', BimbinganController::class);
    Route::resource('suratpengantar', SuratPengantarController::class);
    Route::get('/suratpengantar/{suratpengantar}/file', [SuratPengantarController::class, 'file'])->name('suratpengantar.file');

    Route::resource('nilai', NilaiController::class);
    Route::get('/nilai/{id}/pdf', [NilaiController::class, 'servePdf'])->name('nilai.pdf');
    Route::resource('user', UserController::class);
    Route::get('/user/{user}/photo', [UserController::class, 'photo'])->name('user.photo');
    Route::post('/user/{user}/validate', [UserController::class, 'validate'])->name('user.validate');
    Route::resource('datadosen', DataDosenController::class);
    Route::resource('pemberkasan', PemberkasanController::class);

    // Koorprodi Routes
    Route::get('/koorprodi', [KoorprodiController::class, 'index'])->name('koorprodi.index');
    Route::get('/koorprodi/user', [KoorprodiController::class, 'user_index'])->name('koorprodi.user.index');
    Route::get('/koorprodi/user/create', [KoorprodiController::class, 'user_create'])->name('koorprodi.user.create');
    Route::post('/koorprodi/user', [KoorprodiController::class, 'user_store'])->name('koorprodi.user.store');
    Route::get('/koorprodi/user/{user}', [KoorprodiController::class, 'user_show'])->name('koorprodi.user.show');
    Route::get('/koorprodi/user/{user}/edit', [KoorprodiController::class, 'user_edit'])->name('koorprodi.user.edit');
    Route::put('/koorprodi/user/{user}', [KoorprodiController::class, 'user_update'])->name('koorprodi.user.update');
    Route::delete('/koorprodi/user/{user}', [KoorprodiController::class, 'user_destroy'])->name('koorprodi.user.destroy');
    Route::get('/koorprodi/datamahasiswa', [KoorprodiController::class, 'datamahasiswa_index'])->name('koorprodi.datamahasiswa.index');
    Route::get('/koorprodi/datamahasiswa/create', [KoorprodiController::class, 'datamahasiswa_create'])->name('koorprodi.datamahasiswa.create');
    Route::post('/koorprodi/datamahasiswa', [KoorprodiController::class, 'datamahasiswa_store'])->name('koorprodi.datamahasiswa.store');
    Route::get('/koorprodi/datamahasiswa/{datamahasiswa}', [KoorprodiController::class, 'datamahasiswa_show'])->name('koorprodi.datamahasiswa.show');
    Route::get('/koorprodi/datamahasiswa/{datamahasiswa}/edit', [KoorprodiController::class, 'datamahasiswa_edit'])->name('koorprodi.datamahasiswa.edit');
    Route::put('/koorprodi/datamahasiswa/{datamahasiswa}', [KoorprodiController::class, 'datamahasiswa_update'])->name('koorprodi.datamahasiswa.update');
    Route::delete('/koorprodi/datamahasiswa/{datamahasiswa}', [KoorprodiController::class, 'datamahasiswa_destroy'])->name('koorprodi.datamahasiswa.destroy');
    Route::get('/koorprodi/penguji', [KoorprodiController::class, 'penguji_index'])->name('koorprodi.penguji.index');
    Route::get('/koorprodi/penguji/create', [KoorprodiController::class, 'penguji_create'])->name('koorprodi.penguji.create');
    Route::post('/koorprodi/penguji', [KoorprodiController::class, 'penguji_store'])->name('koorprodi.penguji.store');
    Route::get('/koorprodi/penguji/{penguji}', [KoorprodiController::class, 'penguji_show'])->name('koorprodi.penguji.show');
    Route::get('/koorprodi/penguji/{penguji}/edit', [KoorprodiController::class, 'penguji_edit'])->name('koorprodi.penguji.edit');
    Route::put('/koorprodi/penguji/{penguji}', [KoorprodiController::class, 'penguji_update'])->name('koorprodi.penguji.update');
    Route::delete('/koorprodi/penguji/{penguji}', [KoorprodiController::class, 'penguji_destroy'])->name('koorprodi.penguji.destroy');

    Route::get('/koorprodi/proposal', [KoorprodiController::class, 'proposal_index'])->name('koorprodi.proposal.index');
    Route::get('/koorprodi/proposal/create', [KoorprodiController::class, 'proposal_create'])->name('koorprodi.proposal.create');
    Route::post('/koorprodi/proposal', [KoorprodiController::class, 'proposal_store'])->name('koorprodi.proposal.store');
    Route::get('/koorprodi/proposal/{proposal}', [KoorprodiController::class, 'proposal_show'])->name('koorprodi.proposal.show');
    Route::get('/koorprodi/proposal/{proposal}/edit', [KoorprodiController::class, 'proposal_edit'])->name('koorprodi.proposal.edit');
    Route::put('/koorprodi/proposal/{proposal}', [KoorprodiController::class, 'proposal_update'])->name('koorprodi.proposal.update');
    Route::delete('/koorprodi/proposal/{proposal}', [KoorprodiController::class, 'proposal_destroy'])->name('koorprodi.proposal.destroy');

    Route::get('/koorprodi/datadosen', [KoorprodiController::class, 'datadosen_index'])->name('koorprodi.datadosen.index');
    Route::get('/koorprodi/datadosen/create', [KoorprodiController::class, 'datadosen_create'])->name('koorprodi.datadosen.create');
    Route::post('/koorprodi/datadosen', [KoorprodiController::class, 'datadosen_store'])->name('koorprodi.datadosen.store');
    Route::get('/koorprodi/datadosen/{datadosen}', [KoorprodiController::class, 'datadosen_show'])->name('koorprodi.datadosen.show');
    Route::get('/koorprodi/datadosen/{datadosen}/edit', [KoorprodiController::class, 'datadosen_edit'])->name('koorprodi.datadosen.edit');
    Route::put('/koorprodi/datadosen/{datadosen}', [KoorprodiController::class, 'datadosen_update'])->name('koorprodi.datadosen.update');
    Route::delete('/koorprodi/datadosen/{datadosen}', [KoorprodiController::class, 'datadosen_destroy'])->name('koorprodi.datadosen.destroy');
    
    Route::get('/koorprodi/seminar', [KoorprodiController::class, 'seminar_index'])->name('koorprodi.seminar.index');
    Route::get('/koorprodi/suratpengantar', [KoorprodiController::class, 'suratpengantar_index'])->name('koorprodi.suratpengantar.index');
    Route::get('/koorprodi/pemberkasan', [KoorprodiController::class, 'pemberkasan_index'])->name('koorprodi.pemberkasan.index');
     
    // Google Sheet
    Route::get('/sheets/list', [GoogleSheetController::class, 'index'])->name('sheets.list');
    Route::post('/nilai/import', [NilaiController::class, 'import'])->name('nilai.import');
    Route::post('/nilai/import-pdf', [NilaiController::class, 'importPdf'])->name('nilai.importPdf');

    // Staf Routes
    Route::get('/staf', [StafController::class, 'index'])->name('staf.index');
    
    // Staf - Data Mahasiswa Management
    Route::get('/staf/datamahasiswa', [StafController::class, 'datamahasiswa_index'])->name('staf.datamahasiswa.index');
    Route::get('/staf/datamahasiswa/create', [StafController::class, 'datamahasiswa_create'])->name('staf.datamahasiswa.create');
    Route::post('/staf/datamahasiswa', [StafController::class, 'datamahasiswa_store'])->name('staf.datamahasiswa.store');
    Route::get('/staf/datamahasiswa/{datamahasiswa}', [StafController::class, 'datamahasiswa_show'])->name('staf.datamahasiswa.show');
    Route::get('/staf/datamahasiswa/{datamahasiswa}/edit', [StafController::class, 'datamahasiswa_edit'])->name('staf.datamahasiswa.edit');
    Route::put('/staf/datamahasiswa/{datamahasiswa}', [StafController::class, 'datamahasiswa_update'])->name('staf.datamahasiswa.update');
    Route::delete('/staf/datamahasiswa/{datamahasiswa}', [StafController::class, 'datamahasiswa_destroy'])->name('staf.datamahasiswa.destroy');
    
    // Staf - Resource Controllers
    // Staf - Nilai Management
    Route::get('/staf/nilai', [StafController::class, 'nilai_index'])->name('staf.nilai.index');
    Route::get('/staf/nilai/create', [StafController::class, 'nilai_create'])->name('staf.nilai.create');
    Route::post('/staf/nilai', [StafController::class, 'nilai_store'])->name('staf.nilai.store');
    Route::get('/staf/nilai/{nilai}', [StafController::class, 'nilai_show'])->name('staf.nilai.show');
    Route::get('/staf/nilai/{nilai}/edit', [StafController::class, 'nilai_edit'])->name('staf.nilai.edit');
    Route::put('/staf/nilai/{nilai}', [StafController::class, 'nilai_update'])->name('staf.nilai.update');
    Route::delete('/staf/nilai/{nilai}', [StafController::class, 'nilai_destroy'])->name('staf.nilai.destroy');
    Route::get('/staf/nilai/{id}/pdf', [StafController::class, 'nilai_serve_pdf'])->name('staf.nilai.pdf');
    Route::post('/staf/nilai/import-pdf', [StafController::class, 'nilai_import_pdf'])->name('staf.nilai.importPdf');
    // Staf - Tempat PKL Management
    Route::get('/staf/tempatpkl', [StafController::class, 'tempatpkl_index'])->name('staf.tempatpkl.index');
    Route::get('/staf/tempatpkl/create', [StafController::class, 'tempatpkl_create'])->name('staf.tempatpkl.create');
    Route::post('/staf/tempatpkl', [StafController::class, 'tempatpkl_store'])->name('staf.tempatpkl.store');
    Route::get('/staf/tempatpkl/{tempatpkl}', [StafController::class, 'tempatpkl_show'])->name('staf.tempatpkl.show');
    Route::get('/staf/tempatpkl/{tempatpkl}/edit', [StafController::class, 'tempatpkl_edit'])->name('staf.tempatpkl.edit');
    Route::put('/staf/tempatpkl/{tempatpkl}', [StafController::class, 'tempatpkl_update'])->name('staf.tempatpkl.update');
    Route::delete('/staf/tempatpkl/{tempatpkl}', [StafController::class, 'tempatpkl_destroy'])->name('staf.tempatpkl.destroy');

    // Staf - Seminar Management
    Route::get('/staf/seminar', [StafController::class, 'seminar_index'])->name('staf.seminar.index');
    Route::get('/staf/seminar/create', [StafController::class, 'seminar_create'])->name('staf.seminar.create');
    Route::post('/staf/seminar', [StafController::class, 'seminar_store'])->name('staf.seminar.store');
    Route::get('/staf/seminar/{seminar}', [StafController::class, 'seminar_show'])->name('staf.seminar.show');
    Route::get('/staf/seminar/{seminar}/edit', [StafController::class, 'seminar_edit'])->name('staf.seminar.edit');
    Route::put('/staf/seminar/{seminar}', [StafController::class, 'seminar_update'])->name('staf.seminar.update');
    Route::delete('/staf/seminar/{seminar}', [StafController::class, 'seminar_destroy'])->name('staf.seminar.destroy');


    // Staf - Data Dosen Management
    Route::get('/staf/datadosen', [StafController::class, 'datadosen_index'])->name('staf.datadosen.index');
    Route::get('/staf/datadosen/create', [StafController::class, 'datadosen_create'])->name('staf.datadosen.create');
    Route::post('/staf/datadosen', [StafController::class, 'datadosen_store'])->name('staf.datadosen.store');
    Route::get('/staf/datadosen/{datadosen}', [StafController::class, 'datadosen_show'])->name('staf.datadosen.show');
    Route::get('/staf/datadosen/{datadosen}/edit', [StafController::class, 'datadosen_edit'])->name('staf.datadosen.edit');
    Route::put('/staf/datadosen/{datadosen}', [StafController::class, 'datadosen_update'])->name('staf.datadosen.update');
    Route::delete('/staf/datadosen/{datadosen}', [StafController::class, 'datadosen_destroy'])->name('staf.datadosen.destroy');

    // kelola status
    Route::resource('status', StatusController::class);

    Route::resource('pemberkasan', PemberkasanController::class);
    Route::get('/pemberkasan/{pemberkasan}/file/{field}', [PemberkasanController::class, 'file'])->name('pemberkasan.file');
    Route::post('/pemberkasan/upload', [PemberkasanController::class, 'store'])->name('pemberkasan.store');

    // Kelola User-Dosen
    Route::prefix('dosen/user')->group(function () {
    Route::get('/', [UserDosenController::class, 'index'])->name('dosen.user.index');
    Route::get('/create', [UserDosenController::class, 'create'])->name('dosen.user.create');
    Route::post('/', [UserDosenController::class, 'store'])->name('dosen.user.store');
    Route::get('/{id}', [UserDosenController::class, 'show'])->name('dosen.user.show');
    Route::get('/{id}/edit', [UserDosenController::class, 'edit'])->name('dosen.user.edit');
    Route::put('/{id}', [UserDosenController::class, 'update'])->name('dosen.user.update');
    Route::delete('/{id}', [UserDosenController::class, 'destroy'])->name('dosen.user.destroy');
});

    // Proposal - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::prefix('proposal')->name('proposal.')->group(function () {
            Route::get('/', [ProposalDosenController::class, 'index'])->name('indexdosen');
            Route::get('/create', [ProposalDosenController::class, 'create'])->name('createdosen');
            Route::post('/', [ProposalDosenController::class, 'store'])->name('store');
            Route::get('/{proposal}/edit', [ProposalDosenController::class, 'edit'])->name('editdosen');
            Route::get('/{proposal}', [ProposalDosenController::class, 'show'])->name('showdosen');
            Route::put('/{proposal}', [ProposalDosenController::class, 'update'])->name('updatedosen');
            Route::delete('/{proposal}', [ProposalDosenController::class, 'destroy'])->name('destroy');
        });
    });

    // Surat Pengantar - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::prefix('suratpengantar')->name('suratpengantar.')->group(function () {
            Route::get('/', [SuratPengantarDosenController::class, 'index'])->name('indexdosen');
            Route::get('/create', [SuratPengantarDosenController::class, 'create'])->name('createdosen');
            Route::post('/', [SuratPengantarDosenController::class, 'store'])->name('store');
            Route::get('/{suratpengantar}/edit', [SuratPengantarDosenController::class, 'edit'])->name('editdosen');
            Route::get('/{suratpengantar}', [SuratPengantarDosenController::class, 'show'])->name('showdosen');
            Route::put('/{suratpengantar}', [SuratPengantarDosenController::class, 'update'])->name('updatedosen');
            Route::delete('/{suratpengantar}', [SuratPengantarDosenController::class, 'destroy'])->name('destroy');
        });
    });

    // Pemberkasan - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::prefix('pemberkasan')->name('pemberkasan.')->group(function () {
            Route::get('/', [PemberkasanDosenController::class, 'index'])->name('indexdosen');
            Route::get('/create', [PemberkasanDosenController::class, 'create'])->name('createdosen');
            Route::post('/', [PemberkasanDosenController::class, 'store'])->name('store');
            Route::get('/{pemberkasan}/edit', [PemberkasanDosenController::class, 'edit'])->name('editdosen');
            Route::get('/{pemberkasan}', [PemberkasanDosenController::class, 'show'])->name('showdosen');
            Route::put('/{pemberkasan}', [PemberkasanDosenController::class, 'update'])->name('updatedosen');
            Route::delete('/{pemberkasan}', [PemberkasanDosenController::class, 'destroy'])->name('destroy');
        });
    });

    // Dosen Data Mahasiswa
    Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::resource('datamahasiswa', DosenDataMahasiswaController::class);
});

    //Dosen-Nilai
    Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::prefix('nilai')->name('nilai.')->group(function () {
        Route::get('/', [NilaiDosenController::class, 'index'])->name('indexdosen');
        Route::post('/', [NilaiDosenController::class, 'store'])->name('storedosen');
        Route::get('/create', [NilaiDosenController::class, 'create'])->name('createdosen');
        Route::get('/{id}/edit', [NilaiDosenController::class, 'edit'])->name('editdosen');
        Route::get('/{id}', [NilaiDosenController::class, 'show'])->name('showdosen');
        Route::delete('/{id}', [NilaiDosenController::class, 'destroy'])->name('destroydosen');
    });

    // Tambahan khusus fitur import
    Route::post('/import', [NilaiDosenController::class, 'import'])->name('import');
    Route::post('/import-pdf', [NilaiDosenController::class, 'importPdf'])->name('importpdf');
});

    //Data Dosen - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::prefix('datadosen')->name('datadosen.')->group(function () {
        Route::get('/', [DosenDataDosenController::class, 'index'])->name('indexdatadosen');
        Route::get('/create', [DosenDataDosenController::class, 'create'])->name('createdatadosen');
        Route::post('/', [DosenDataDosenController::class, 'store'])->name('storedatadosen');
        Route::get('/{datadosen}', [DosenDataDosenController::class, 'show'])->name('showdatadosen');
        Route::get('/{datadosen}/edit', [DosenDataDosenController::class, 'edit'])->name('editdatadosen');
        Route::put('/{datadosen}', [DosenDataDosenController::class, 'update'])->name('updatedatadosen');
        Route::delete('/{datadosen}', [DosenDataDosenController::class, 'destroy'])->name('destroydatadosen');
    });
});

    // Bimbingan - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::prefix('bimbingan')->name('bimbingan.')->group(function () {
        Route::get('/', [BimbinganDosenController::class, 'index'])->name('indexdosen');
        Route::get('/create', [BimbinganDosenController::class, 'create'])->name('createdosen');
        Route::post('/', [BimbinganDosenController::class, 'store'])->name('store');
        Route::get('/{bimbingan}', [BimbinganDosenController::class, 'show'])->name('showdosen');
        Route::get('/{bimbingan}/edit', [BimbinganDosenController::class, 'edit'])->name('editdosen');
        Route::put('/{bimbingan}', [BimbinganDosenController::class, 'update'])->name('updatedosen');
        Route::delete('/{bimbingan}', [BimbinganDosenController::class, 'destroy'])->name('destroy');
    });
});

    // Penguji - Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::prefix('penguji')->name('penguji.')->group(function () {
        Route::get('/', [PengujiDosenController::class, 'index'])->name('indexdosen');
        Route::get('/create', [PengujiDosenController::class, 'create'])->name('createdosen');
        Route::post('/', [PengujiDosenController::class, 'store'])->name('store');
        Route::get('/{penguji}', [PengujiDosenController::class, 'show'])->name('showdosen');
        Route::get('/{penguji}/edit', [PengujiDosenController::class, 'edit'])->name('editdosen');
        Route::put('/{penguji}', [PengujiDosenController::class, 'update'])->name('updatedosen');
        Route::delete('/{penguji}', [PengujiDosenController::class, 'destroy'])->name('destroy');
    });
});

    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::prefix('seminar')->name('seminar.')->group(function () {
            Route::get('/', [SeminarDosenController::class, 'index'])->name('indexdosen');
            Route::get('/create', [SeminarDosenController::class, 'create'])->name('createdosen');
            Route::post('/', [SeminarDosenController::class, 'store'])->name('store');
            Route::get('/{seminar}/edit', [SeminarDosenController::class, 'edit'])->name('editdosen');
            Route::get('/{seminar}', [SeminarDosenController::class, 'show'])->name('showdosen');
            Route::put('/{seminar}', [SeminarDosenController::class, 'update'])->name('updatedosen');
            Route::delete('/{seminar}', [SeminarDosenController::class, 'destroy'])->name('destroy');
        });
    });

    Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/lihatdetailipk', [LihatDetailIpkController::class, 'index'])->name('mahasiswa.lihatdetailipk.index');
    Route::get('/mahasiswa/lihatsemuatempatpkl', [LihatSemuaTempatPKLController::class, 'index'])->name('mahasiswa.lihatsemua');

});

    Route::middleware(['auth'])->group(function () {

    // Lihat profil & pengaturan
    Route::get('/profil', [ProfilController::class, 'index'])->name('mahasiswa.profil');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('mahasiswa.pengaturan');

    // Update profil
    Route::post('/profil', [ProfilController::class, 'update'])->name('mahasiswa.profil.update');

    // Update password
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])
        ->name('mahasiswa.profil.update_password');

    // Update pengaturan
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('mahasiswa.pengaturan.update');

    // Update preferensi
    Route::post('/pengaturan/preferensi', [PreferensiController::class, 'update'])->name('mahasiswa.preferensi.update');
});

    // Daftar Dosen
    Route::get('/daftardosen', [MahasiswaDosenController::class, 'daftardosen'])
    ->name('dosen.daftardosen')
    ->middleware('auth');

    // Dosen Pembimbing
    Route::get('/dosenpembimbing', [MahasiswaDosenController::class, 'dosenpembimbing'])
    ->name('dosen.dosenpembimbing')
    ->middleware('auth');

    // Bimbingan - Mahasiswa
    Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/bimbingan', [MahasiswaBimbinganController::class, 'index'])->name('mahasiswa.bimbingan.index');
    Route::get('/lihat-tempat-pkl', [MahasiswaTempatPKLController::class, 'index'])->name('tempatpkl.lihattempatpkl');
    Route::get('/aktivitas', [\App\Http\Controllers\Mahasiswa\AktivitasController::class, 'index'])->name('aktivitas.index');
    Route::post('/aktivitas/store', [\App\Http\Controllers\Mahasiswa\AktivitasController::class, 'store'])->name('aktivitas.store');
    
    // ======================
    // PROPOSAL PKL
    // ======================
    Route::get('/proposal/upload', [UploadProposalController::class, 'create'])
        ->name('mahasiswa.proposal.upload');

    Route::post('/proposal/upload', [UploadProposalController::class, 'store'])
        ->name('mahasiswa.proposal.store');

    Route::get('/mahasiswa/proposal/{id}/lihat', function ($id) {
    $proposal = Proposal::findOrFail($id); // <--- pastikan model Proposal

    // Pastikan hanya owner yang bisa lihat
    if ($proposal->nim !== Auth::user()->nim) {
        abort(403, 'Forbidden');
    }

    $path = storage_path('app/public/' . $proposal->file_proposal);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->file($path);
})->name('proposal.lihat')->middleware(['auth', 'role:mahasiswa']);

    // Halaman upload proposal
    Route::get('/proposal/upload', [UploadProposalController::class, 'index'])
        ->name('mahasiswa.proposal.upload');

    // Halaman Pemberkasan (Mahasiswa)
    Route::get('/pemberkasan/upload', [PemberkasanMahasiswaController::class, 'index'])
        ->name('mahasiswa.pemberkasan.upload');

    // Proses upload pemberkasan
    Route::post('/pemberkasan/store', [PemberkasanMahasiswaController::class, 'store'])
        ->name('mahasiswa.pemberkasan.store');

    Route::get('/pemberkasan/view/{file}', function($file){
    $path = storage_path('app/public/pemberkasan/' . $file);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path); // akan membuka PDF di browser
})->name('pemberkasan.view');

    Route::get('/ajukan-tempat-pkl', [AjukanTempatPKLController::class, 'create'])->name('tempatpkl.ajukantempatpkl');
    Route::post('/upload-pdf', [AjukanTempatPKLController::class, 'uploadPdf'])->name('tempatpkl.uploadPdf');
    Route::post('/store', [AjukanTempatPKLController::class, 'store'])->name('tempatpkl.store');

    Route::get('/pemberkasan/view/{type}/{id}', [PemberkasanMahasiswaController::class, 'viewFile'])
    ->name('pemberkasan.view');

    // Proses penyimpanan data upload
    Route::post('/proposal/store', [UploadProposalController::class, 'store'])
        ->name('mahasiswa.proposal.store');

    // Halaman Jadwal Seminar (untuk mahasiswa)
    Route::get('/seminar/jadwal', [JadwalSeminarController::class, 'index'])
        ->name('seminar.jadwal');

    Route::get('/seminar/{id}', [JadwalSeminarController::class, 'show'])
        ->name('seminar.show');

});
    Route::get('/test-email', function () {
    Mail::raw('Tes email dari Laravel SIPRAKERLA', function ($message) {
        $message->to('emailtujuan@gmail.com')
                ->subject('Tes Email Laravel');
    });

Route::get('/koor-pkl/profil', [KoorPklController::class, 'showProfile'])->name('koor.profil');
Route::post('/koor-pkl/profil', [KoorPklController::class, 'updateProfile'])->name('koor.profil.update');

    return 'Email terkirim!';

});
    Route::post('/notifikasi/baca-semua', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return back();
    
})
    ->name('notifikasi.baca');
});

    Route::middleware(['auth','role:koordinator'])->prefix('koordinator')->group(function() {
    Route::get('/dashboard', [KoorPklController::class, 'index'])->name('koor.dashboard');
    Route::post('/pengajuan-pkl/{id}/validasi', [KoorPklController::class, 'validasiPengajuan'])->name('koor.pengajuan.validasi');
    Route::post('/pengajuan-pkl/{id}/nilai', [KoorPklController::class, 'beriNilai'])->name('koor.pengajuan.beriNilai');
    Route::post('/proposal/{proposal}/validate', [KoorPklController::class, 'validateProposal'])->name('koor.proposal.validate');
});
