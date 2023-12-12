<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarRate extends Model
{
    use HasFactory;

    protected $table = 'komentar_rate';

    protected $fillable = [
        'id_pemancingan',
        'id_user',
        'komentar',
        'rate'
    ];


    public function userKomentar()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
