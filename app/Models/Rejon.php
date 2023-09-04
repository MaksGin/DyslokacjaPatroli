<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejon extends Model
{
    use HasFactory;

    protected $fillable = ['nazwa', 'created_by'];
}
