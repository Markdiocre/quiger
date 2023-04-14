<?php

use App\Broadcasting\LobbyChannel;
use App\Broadcasting\QuizJoin;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('quiz.{quiz_id}', function(User $user, $quiz_id){
    if($user->hasJoined($quiz_id)){
        return $user;
    }

    return null;
});
