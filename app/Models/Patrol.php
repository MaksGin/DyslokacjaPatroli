<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrol extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['kom','data','g_rozp','g_zak','uwagi','rejon','krypt','user_id'];

    public function wydzialy()
    {
        return $this->belongsToMany(Wydzial::class, 'patrol_wydzial', 'patrol_id', 'wydzial_id');
    }
    // Definicja relacji z tabelą Sklad
    public function sklad()
    {
        return $this->hasMany(Sklad::class, 'id_patrolu');
    }
}
