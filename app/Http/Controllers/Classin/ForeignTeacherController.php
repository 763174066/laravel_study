<?php

namespace App\Http\Controllers\Classin;

use App\Exports\VideoUrlExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoUrlCollection;
use App\Models\ClassinLessonVideo;
use App\Models\ClassinOldLessonInfo;
use App\Models\ForeignTeacher;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Maatwebsite\Excel\Facades\Excel;


class ForeignTeacherController extends Controller
{
    public function getTeachers()
    {
        
    }
}
