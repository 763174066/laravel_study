<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassinSubscribeMsg extends Model
{
    use HasFactory;

    protected $fillable = [
        "ClassID", "ActionTime", "UID",
        "CourseID", "TimeStamp", "Cmd",
        "_id", "SID", "SafeKey", "Data",
        'ActionTime','SourceUID','TargetUID',
    ];

}
