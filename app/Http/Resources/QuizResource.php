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
            'description' => $this->description,
            'name'=> $this->name ? $this->name : $this->id,
            'status' => $this->status,
            'creator' => new UserResource($this->user),
            'joiners'=> new UserCollection($this->users),
            'craeted_at' => $this->created_at,
            'admin'=> $request->user()->id == $this->user->id ? true: false,
        ];
    }
}
