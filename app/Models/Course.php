<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';
    /**
     * @var string[]
     */
    protected $fillable = [
        'course_name',
        'course_id',
        'begin_time',
        'total_class_num',
        'course_info',
    ];
    /**
     * @var string[]
     */
    protected $casts = [
        'course_info' => 'json',
        'begin_time' => 'datetime',
    ];
}
