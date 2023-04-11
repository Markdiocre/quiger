<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function get_all($id)
    {
        return new QuestionCollection(Question::all()->where('quiz_id', '=', $id));
    }

    public function get_specific($id)
    {
        return new QuestionResource(Question::all()->where('id', '=', $id)->first());
    }

    public function create_question(Request $request)
    {
        $question = new Question;

        $question->content = $request->content;
        $question->score = $request->score;
        $question->quiz_id = $request->quizId;

        if(!$question->save()){
            return response()->json(['message'=>'Error, cannot insert Question'])->setStatusCode(400);
        }

        foreach($request->choices as $choice_r){
            $choice = new Choice;

            $choice->content = $choice_r["content"];
            $choice->is_correct = $choice_r["isCorrect"];
            $choice->question_id = $question->id;

            if(!$choice->save()){
                return response()->json(['message'=>'Error, cannot update Product'])->setStatusCode(400);
            }
        }

        return response()->json(['message'=>'Successfuly created Question!'])->setStatusCode(200);
    }

    public function update_question(Request $request, $id)
    {
        $question = Question::all()->where('id','=',$id)->first();

        $question->content = $request->content;
        $question->score = $request->score;

        if(!$question->save()){
            return response()->json(['message'=>'Error, cannot update Question'])->setStatusCode(400);
        }

        foreach($request->choices as $choice_r){
            $choice = Choice::all()->where('id','=',$choice_r['id'])->first();

            $choice->content = $choice_r["content"];
            $choice->is_correct = $choice_r["isCorrect"];

            if(!$choice->save()){
                return response()->json(['message'=>'Error, cannot update Product'])->setStatusCode(400);
            }
        }

        return response()->json(['message'=>'Successfuly created Question!'])->setStatusCode(200);

    }

    public function delete_question($id)
    {
        $question = Question::all()->where('id','=',$id)->first();
        if ($question->delete()) {
            return response()->json(['message' => 'Successfully Deleted!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot delete order'])->setStatusCode(400);
    }
}
