<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassinLessonVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'course_id',
        'lesson_id',
        'course_name',
        'class_name',
        'begin_time',
        'url',
        'has_download',
    ];

    protected $dates = [
        'begin_time',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson(){
        return $this->belongsTo(ClassinOldLessonInfo::class,'lesson_id','lesson_id');
    }
}
