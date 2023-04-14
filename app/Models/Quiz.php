<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User', 'quiz_user');
    }

    public function join($user){
        return $this->users()->attach($user);
    }

    public function leave($user){
        return $this->users()->detach($user);
    }
}
