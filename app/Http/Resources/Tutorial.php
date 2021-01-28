<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tutorial extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'date'=>$this->date,
            'hour'=>$this->hour,
            'observation'=>$this->observation,
            'topic'=>$this->topic,
            'student'=>'/api/users/' . $this->student_id,
            'teacher'=>'/api/users/' . $this->teacher_id,
            'subject'=>'/api/subjects/' . $this->subject_id,
            'image'=>$this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
