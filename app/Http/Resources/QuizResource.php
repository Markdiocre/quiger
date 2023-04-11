<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'title' => $this->title,
            'name'=> $this->name ? $this->name : $this->id,
            'status' => $this->status,
            'creator' => $this->user_id,
            'craeted_at' => $this->created_at
        ];
    }
}
