<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $guard_name = 'app';

    protected $fillable = [
        'username',
        'password',
    ];
}
