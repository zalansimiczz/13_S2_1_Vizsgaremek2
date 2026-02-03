<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'felhasznalok';
    public $timestamps = false;

    protected $fillable = [
        'teljes_nev',
        'email',
        'jelszo_hash',
        'ceg_id',
        'aktiv',
        'email_verified_at',
        'created_at',
    ];

    protected $hidden = [
        'jelszo_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}

