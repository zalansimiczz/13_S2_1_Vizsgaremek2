<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jarmu extends Model
{
    protected $table = 'jarmuvek';

    //ha csak created_at van
    public $timestamps = false;

    protected $fillable = [
    'ceg_id',
    'kategoria',
    'marka',
    'tipus',
    'tengelyszam',
    'rendszam',
    'vin',
    'euro_besorolas',
    'ossztomeg_kg',
    'potkocsi_kepes',
    'device_id',
    'aktiv',
    'created_at',
];
}