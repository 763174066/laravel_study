<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassinOldLessonInfo extends Model
{
    use HasFactory;
    protected $table = 'classin_old_lesson_infos';
    protected $fillable = [
        'course_id',
        'course_name',
        'lesson_id',
        'class_name',
        'begin_time',
        'end_time',
        'has_get_download_link',
    ];

    const HAS_GET_DOWNLOAD_LINK_YES = 'yes';
    const HAS_GET_DOWNLOAD_LINK_NO = 'no';
}
