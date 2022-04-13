<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;


class UserModel extends User
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'gender',
        'phone',
    ];

    protected $hidden = ['password'];

    public function express()
    {
        return $this->hasMany(Expresses::class);
    }
}
