<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Question\ChoiceQuestion;

class QuestionResource extends JsonResource
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
            'id' => $this->id,
            'content' => $this->content,
            'score' => $this->score,
            'quizId' => $this->quiz_id,
            'choices' => new ChoiceCollection($this->choice)
        ];
    }
}
