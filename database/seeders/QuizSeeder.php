<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quiz = [
            [
                'title'=>"All about Albert",
                'password'=>'Albertus',
                'name'=>'Los albertus Big Cockus',
                'status'=>'private',
                'user_id'=> User::all()->first()->id,
            ]
        ];

        DB::table('quizzes')->insert($quiz);
    }
}
