<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ceg extends Model
{
    protected $table = 'cegek';
    public $timestamps = false;

    protected $fillable = [
        'nev',
        'adoszam',
        'cim',
        'statusz',
    ];
}