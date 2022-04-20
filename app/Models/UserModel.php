<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Traits\HasRoles;


class UserModel extends User
{
    use HasFactory, HasRoles;

    protected $guard_name = 'app';

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
