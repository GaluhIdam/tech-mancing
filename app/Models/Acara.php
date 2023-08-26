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
        'nama_acara',
        'deskripsi',
        'mulai',
        'akhir',
    ];
}
