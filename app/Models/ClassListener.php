<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassListener extends Model
{
    use HasFactory;

    protected $dates = ['start_at', 'end_at'];
    protected $table = 'class_listeners';
    protected $fillable = [
      'lesson_key',
      'start_at',
      'end_at',
      'lesson_info',
      'student_late_notice_times',
      'teacher_late_notice_times',
      'mic_notice_times',
      'cam_notice_times',
    ];
}
