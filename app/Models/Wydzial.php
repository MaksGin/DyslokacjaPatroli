<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wydzial extends Model
{
    protected $table = 'wydzialy';

    protected $fillable = [
        'nazwa',
    ];



    public function users()
    {
        return $this->belongsToMany(User::class, 'user_wydzial', 'wydzial_id', 'user_id');
    }
    public function patrols()
    {
        return $this->belongsToMany(Patrol::class, 'patrol_wydzial', 'patrol_id', 'wydzial_id');
    }


}
