<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sklad extends Model
{
    public $timestamps = false;
    use HasFactory;


    public function patrol()
    {
        return $this->belongsTo(Patrol::class, 'id_patrolu');
    }

    public function kryptonim()
    {
        return $this->Hasone(Kryptonim::class,'krypt_id');
    }
}
