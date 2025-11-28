<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'peserta_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'foto_masuk',
        'foto_keluar',
        'latitude_masuk',
        'longitude_masuk',
        'latitude_keluar',
        'longitude_keluar',
        'status',
        'keterangan',
        'tanda_tangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jam_masuk' => 'datetime',
            'jam_keluar' => 'datetime',
            'latitude_masuk' => 'float',
            'longitude_masuk' => 'float',
            'latitude_keluar' => 'float',
            'longitude_keluar' => 'float',
        ];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
