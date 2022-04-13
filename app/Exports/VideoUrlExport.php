<?php

namespace App\Exports;

use App\Http\Resources\VideoUrlCollection;
use App\Models\ClassinLessonVideo;
use App\Models\OldLessonNum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class VideoUrlExport implements FromCollection
{
    private $year;
    private $month;

    /**
     * VideoUrlExport constructor.
     * @param int $year
     * @param int $month
     */
    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|Collection
     */
    public function collection()
    {
        $data = ClassinLessonVideo::query()
            ->whereYear('begin_time', $this->year)
            ->whereMonth('begin_time', $this->month)
            ->get();

        return VideoUrlCollection::collection($data);
    }
}
