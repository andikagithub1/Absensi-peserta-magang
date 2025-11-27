<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembina extends Model
{
    use HasFactory;

    protected $table = 'pembinas';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'nomor_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
