<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Notifications\ProposalApprovedNotification;

class Proposal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proposals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'judul_proposal',
        'pembimbing',
        'tempat_pkl',
        'file_proposal',
        'tanggal_pengajuan',
        'status',
        'catatan',
    ];

    public function approve($id)
{
    $mahasiswa = User::find($id);

    $mahasiswa->notify(new ProposalApprovedNotification('approved'));

    return back()->with('success', 'Notifikasi email terkirim!');
}

    /**
     * Get the supervising lecturer (dosen) for the proposal.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing');
    }
}
