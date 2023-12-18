<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $table = 'acara';

    protected $fillable = [
        'id_pemancingan',
        'id_user',
        'gambar',
        'path',
        'nama_acara',
        'deskripsi',
        'grand_prize',
        'mulai',
        'akhir',
        'status',
        'pesan'
    ];

    public function pemancinganAcara()
    {
        return $this->belongsTo(Pemancingan::class, 'id_pemancingan', 'id');
    }
}
