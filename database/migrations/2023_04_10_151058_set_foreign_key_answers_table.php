<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table){
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('choice_id')->references('id')->on('choices')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign('answers_question_id_foreign');
            $table->dropIndex('answers_question_id_index');
            $table->dropForeign('answers_quiz_id_foreign');
            $table->dropIndex('answers_quiz_id_index');
            $table->dropForeign('answers_choice_id_foreign');
            $table->dropIndex('answers_choice_id_index');
            $table->dropForeign('answers_user_id_foreign');
            $table->dropIndex('answers_usern_id_index');
        });
    }
};
