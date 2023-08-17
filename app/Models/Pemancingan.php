<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemancingan extends Model
{
    use HasFactory;

    protected $table = 'pemancingan';

    protected $fillable = [
        'id_user',
        'category',
        'image',
        'path',
        'nama_pemancingan',
        'deskripsi',
        'provinsi',
        'kota',
        'kecamatan',
        'alamat',
        'lokasi',
        'status'
    ];
}
