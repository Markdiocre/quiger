<?php

namespace App\Http\Controllers;

use App\Events\QuizJoined;
use App\Http\Resources\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{

    function returnUnique($id)
    {
        return Quiz::all()->where('id', '=', $id)->first();
    }


    public function index()
    {
        return new QuizCollection(Quiz::all()->where('status','=','public'));
    }

    public function show($id)
    {
        $quizzes = $this->returnUnique($id);
        return new QuizResource($quizzes);
    }

    public function store(Request $request)
    {
        $quiz = new Quiz;

        $validatedQuiz = Validator::make($request->all(),[
            'title' => ['required'],
            'password' => ['nullable'],
            'name ' => ['unique', 'nullable'],
            'description' => ['required'],
            'status' => ['required', Rule::in(['public', 'private'])],
        ]);

        if ($validatedQuiz->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validatedQuiz->errors()
            ], 401);
        }


        $quiz->title = $request->title;
        $quiz->password = $request->status == 'private'?$request->password:null;
        $quiz->name = $request->name;
        $quiz->description = $request->description;
        $quiz->status = $request->status;
        $quiz->user_id = $request->user()->id;


        if ($quiz->save()) {
            return response()->json([
                'message' => 'Successfully Inserted!',
                'quiz_id'=> $quiz->id
            ])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot add Quiz'])->setStatusCode(400);
    }

    public function update(Request $request, $id)
    {
        $quiz = $this->returnUnique($id);

        $validatedQuiz = Validator::make($request->all(),[
            'description' => ['required'],
            'title' => ['required'],
            'password' => ['nullable', Rule::requiredIf($request->status == 'private')],
            'name ' => ['unique', 'nullable'],
            'status' => ['required', Rule::in(['public', 'private'])],
        ]);

        if ($validatedQuiz->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validatedQuiz->errors()
            ], 401);
        }

        $quiz->title = $request->title;
        $quiz->password = $request->password;
        $quiz->description = $request->description;
        $quiz->name = $request->name;
        $quiz->status = $request->status;

        if ($quiz->save()) {
            return response()->json(['message' => 'Successfully updated!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot update Quiz'])->setStatusCode(400);
    }

    public function destroy($id)
    {
        $quiz = $this->returnUnique($id);
        if ($quiz->delete()) {
            return response()->json(['message' => 'Successfully Deleted!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot delete order'])->setStatusCode(400);
    }


    //on quiz join event
    public function join(Quiz $quiz, Request $request){
        try{
            $quiz->join($request->user('api'));

            event(new QuizJoined($request->user('api'), $quiz));
        }catch (Exception $e) {
            Log::error('Exception while joining a chat room', [
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    //on quiz leave
    public function leave(Quiz $quiz, Request $request){
        try{
            $request->user('api')->leave($quiz);
        }catch (Exception $e) {
            Log::error('Exception while joining a chat room', [
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }
}
