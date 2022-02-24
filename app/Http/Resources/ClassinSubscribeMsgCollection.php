<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassinSubscribeMsgCollection extends JsonResource
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
            'CourseID' => $this->CourseID,
            'ClassID' => $this->ClassID,
            'Cmd' => $this->Cmd,
            'Data' => json_decode($this->data),

        ];
    }
}
