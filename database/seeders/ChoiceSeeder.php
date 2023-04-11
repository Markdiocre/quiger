<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $choices = [
            [
                'question_id'=>Question::all()->first()->id,
                'content'=>"About 20 inches",
                'is_correct' => false
            ],
            [
                'question_id'=>Question::all()->first()->id,
                'content'=>"1 inches gang",
                'is_correct' => false

            ],
            [
                'question_id'=>Question::all()->first()->id,
                'content'=>"90 inches",
                'is_correct' => true

            ],
            [
                'question_id'=>Question::all()->first()->id,
                'content'=>"Humongous cockus",
                'is_correct' => false

            ],
        ];

        DB::table('choices')->insert($choices);
    }
}
