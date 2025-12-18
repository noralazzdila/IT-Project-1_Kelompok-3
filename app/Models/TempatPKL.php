<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiPKL;
use App\Models\PenilaianTempatPkl;
use App\Models\PengajuanPKL;

class TempatPKL extends Model
{
    use HasFactory;

    protected $table = 'tempat_pkl';

    protected $fillable = [
        'mahasiswa_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'jarak_lokasi',
        'reputasi_perusahaan',
        'fasilitas',
        'kesesuaian_program',
        'lingkungan_kerja',
        'pdf_transkrip',
        'status',
    ];
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function nilaiPKL() {
        return $this->hasOne(NilaiPKL::class);
    }

    /**
     * Relasi ke penilaian yang diberikan oleh mahasiswa.
     */
    public function penilaianMahasiswa()
    {
        return $this->hasMany(PenilaianTempatPkl::class, 'tempat_pkl_id');
    }

    // Metode agregasi untuk mengambil rata-rata nilai dari semua penilaian.
    // Caching sederhana untuk menghindari query berulang dalam satu request.
    
    public function getRataRataJarak()
    {
        if (!isset($this->rataJarak)) {
            $this->rataJarak = $this->penilaianMahasiswa()->avg('jarak');
        }
        return $this->rataJarak ?? 0;
    }
    
    public function getRataRataFasilitas()
    {
        if (!isset($this->rataFasilitas)) {
            $this->rataFasilitas = $this->penilaianMahasiswa()->avg('fasilitas');
        }
        return $this->rataFasilitas ?? 0;
    }
    
    public function getRataRataProgramMagang()
    {
        if (!isset($this->rataProgram)) {
            $this->rataProgram = $this->penilaianMahasiswa()->avg('program_magang');
        }
        return $this->rataProgram ?? 0;
    }
    
    public function getRataRataReputasi()
    {
        if (!isset($this->rataReputasi)) {
            $this->rataReputasi = $this->penilaianMahasiswa()->avg('reputasi');
        }
        return $this->rataReputasi ?? 0;
    }
    
        public function getRataRataKondisiLingkungan()
        {
            if (!isset($this->rataLingkungan)) {
                $this->rataLingkungan = $this->penilaianMahasiswa()->avg('kondisi_lingkungan');
            }
            return $this->rataLingkungan ?? 0;
        }
    
        public function getJumlahPenilai()
        {
            if (!isset($this->jumlahPenilai)) {
                $this->jumlahPenilai = $this->penilaianMahasiswa()->count();
            }
            return $this->jumlahPenilai ?? 0;
        }
    
        public function getRataRataTotal()
        {
            if ($this->getJumlahPenilai() == 0) return 0;
    
            $total = ($this->getRataRataFasilitas() + $this->getRataRataProgramMagang() + $this->getRataRataReputasi() + $this->getRataRataKondisiLingkungan()) / 4;
            return $total;
        }
    
        public function pengajuanPkl()
        {
            return $this->hasMany(PengajuanPKL::class, 'tempat_pkl_id');
        }}