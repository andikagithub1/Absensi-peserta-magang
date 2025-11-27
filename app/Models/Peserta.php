<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas';

    protected $fillable = [
        'user_id',
        'pembina_id',
        'nisn',
        'nama_lengkap',
        'sekolah',
        'jurusan',
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor_hp',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembina()
    {
        return $this->belongsTo(Pembina::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
