<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = [
            [
                'content' => 'How big is albertus big cockus cock?',
                'score' => 20,
                'quiz_id' => Quiz::all()->first()->id
            ]
        ];

        DB::table('questions')->insert($question);
    }
}
