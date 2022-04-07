<?php

namespace App\Exports;

use App\Http\Resources\VideoUrlCollection;
use App\Models\ClassinLessonVideo;
use App\Models\OldLessonNum;
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $hasData = OldLessonNum::query()
            ->where('year', $this->year)
            ->where('month', $this->month)
            ->whereRaw('total_page=page')
            ->exists();
        if (!$hasData) {
            return null;
        }

        $data = ClassinLessonVideo::query()
            ->whereYear('begin_time', $this->year)
            ->whereMonth('begin_time', $this->month)
            ->get();
        return VideoUrlCollection::collection($data);
    }
}
