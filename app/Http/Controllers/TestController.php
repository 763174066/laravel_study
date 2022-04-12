<?php

namespace App\Http\Controllers;

use App\Models\ClassinOldLessonInfo;
use App\Services\EeoService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
//        GetOldLessons::dispatch();
        $postData = [
            'page' => 5,
            'perpage' => 100,
            'classStatus' => 3,
            'sort' => json_encode([
                'sortName' => 'classBtime',
                'sortValue' => 2
            ]),
            'timeRange' => json_encode([
                'startTime' => 1643644800,
                'endTime' => 1646064000,
            ]),
        ];

        //每次获取1页
        $res = (new EeoService())->eeoRequest('/saasajax/course.ajax.php?action=getClassList', $postData);
        $res = $res->json();
    }


}
