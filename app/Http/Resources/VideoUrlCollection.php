<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoUrlCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'lesson_id' => $this->lesson_id,
            'course_name' => $this->course_name,
            'class_name' => $this->class_name,
            'begin_time' => $this->begin_time->format('Y-m-d H:i:s'),
            'url' => $this->url,
            'has_download' => $this->has_download,
        ];
    }
}
