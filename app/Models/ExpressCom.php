<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpressCom extends Model
{
    use HasFactory;

    protected $fillable = ['name','com'];

    protected $casts = [
//        'is_use' => 'boolean',
    ];
}
