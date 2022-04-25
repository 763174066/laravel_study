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
    public function getTeachers(){
        $path = '/saasajax/teacher.ajax.php?action=getSchoolTeacherFullList';
        $data = [
            'page' => 1,
            'perpage' => 50,
            'labelIds' => 211873,
            'status' => 0
        ];

        $res = (new EeoService())->eeoRequest($path,$data)->json();
        if($res['error_info']['errno'] != 1){
            return;
        }
        if(empty($res['data']['list'])){
            return;
        }

        foreach ($res['data']['list'] as $item){
            ForeignTeacher::query()->firstOrCreate([
                'eeo_id' => $item['id'],
            ],[
                'account' => $item['account'],
                'name' => $item['name'],
                'eeo_u_id' => $item['uid'],
            ]);
        }
    }
}
