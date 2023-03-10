<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userM extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'password',
        'nama_user',
        'role',
        'no_hp'
    ];
}
