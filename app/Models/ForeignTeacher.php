<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForeignTeacher extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'foreign_teachers';
    protected $fillable = [
      'account',
      'eeo_id',
      'name',
      'eeo_u_id',
    ];
}
