<?php

namespace App\Http\Controllers\Classin;

use App\Http\Controllers\Controller;


class GetOldLessonsController extends Controller
{

    public function getOldLessons(){
        $params = $this->validateWith([
            'year' => ['int','required'],
            'month' => ['int','required'],
        ]);

        $this->getOldLessonsNum($params['year'],$params['month']);
    }

    private function getOldLessonsNum($year,$month){
        $startTime = strtotime($year.'-'.$month.'-1');
        $endTime = strtotime($year.'-'.$month.'-1 +1 month');
        dd($startTime,$endTime);
//        $data = [
//            'page' => ,
//            'perpage' => ,
//            'classStatus' => 3,
//            'sort' => json_encode([
//                'sortName' => 'classBtime',
//                'sortValue' => 2
//            ]),
//            'timeRange' => json_encode([
//                'startTime' => ,
//                'endTime' => ,
//            ]),
//        ];
    }


}
