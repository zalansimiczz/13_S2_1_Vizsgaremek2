<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sofor extends Model
{
    protected $table = 'soforok';

    // ha csak created_at van és nincs updated_at:
    public $timestamps = false;

    protected $fillable = [
        'szemelyi_azonosito',
        'nev',
        'szuletesi_datum',
        'telefonszam',
        'cim',
        'adoszam',
        'aktiv',
        'created_at',
    ];
}
