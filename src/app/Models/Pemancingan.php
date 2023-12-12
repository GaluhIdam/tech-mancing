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
        'status',
        'buka',
        'tutup',
        'pesan',
        'latitude',
        'longitude',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
    ];

    public function userPemancingan()
    {
        return $this->belongsTo(User::class, "id_user", "id");
    }

    public function acaraPemancingan()
    {
        return $this->hasMany(Acara::class, "id");
    }

    public function komentarPemancingan()
    {
        return $this->hasMany(KomentarRate::class, "id_pemancingan", "id")->orderBy('created_at', 'desc');
    }
}
