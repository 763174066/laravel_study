<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldLessonNum extends Model
{
    use HasFactory;
    protected $table = 'old_lesson_nums';
    protected $fillable = [
      'year',
      'month',
      'start_time',
      'end_time',
      'num',
      'per_page',
      'total_page',
      'page',
    ];
}
