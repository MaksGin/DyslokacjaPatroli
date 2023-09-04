<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KryptSklad extends Model
{
    protected $table = 'krypt_sklad';

    protected $fillable = ['krypt_id', 'sklad_id'];

    public $timestamps = false;




    public function kryptonim()
    {
        return $this->belongsTo(Kryptonim::class, 'krypt_id');
    }

    public function sklad()
    {
        return $this->belongsTo(Sklad::class, 'sklad_id');
    }
}
