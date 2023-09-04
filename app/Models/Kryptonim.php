<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kryptonim extends Model
{
    use HasFactory;

    protected $fillable = ['nazwa', 'created_by'];


    public function sklad()
    {
        $this->Belongsto(Sklad::class,'sklad_id');
    }
}
