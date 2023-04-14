<?php

namespace App\Events;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $broadcastQueue = 'events:quiz-joined';

     public $user;
     public $quiz;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,  Quiz $quiz)
    {
        $this->user = $user;
        $this->quiz = $quiz;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith(){
        return [
            'id' => $this->user->id,
            'firstName' => $this->user->first_name,
            'lastName' => $this->user->last_name,
        ];
    }

    public function broadcastOn()
    {
        return new PresenceChannel('quiz'.$this->quiz->id);
    }

    // public function broadcastAs()
    // {
    //     return 'quiz.joined';
    // }
}
