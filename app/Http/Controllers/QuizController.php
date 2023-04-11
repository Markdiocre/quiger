<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    function returnUnique($id)
    {
        return Quiz::all()->where('id', '=', $id)->first();
    }


    public function index()
    {
        return new QuizCollection(Quiz::all());
    }

    public function show($id)
    {
        $quizzes = $this->returnUnique($id);
        return new QuizResource($quizzes);
    }

    public function store(Request $request)
    {
        $quiz = new Quiz;

        $validate = $request->validate([
            'title' => ['required'],
            'password' => ['nullable'],
            'name ' => ['unique', 'nullable'],
            'status' => ['required', Rule::in(['public', 'private'])],
            'creator' => ['required']
        ]);

        $quiz->title = $request->title;
        $quiz->password = $request->password;
        $quiz->name = $request->name;
        $quiz->status = $request->status;
        $quiz->user_id = $request->creator;

        if ($quiz->save()) {
            return response()->json(['message' => 'Successfully Inserted!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot add Quiz'])->setStatusCode(400);
    }

    public function update(Request $request, $id)
    {
        $quiz = $this->returnUnique($id);

        $validate = $request->validate([
            'title' => ['required'],
            'password' => ['nullable', Rule::requiredIf($request->status == 'private')],
            'name ' => ['unique', 'nullable'],
            'status' => ['required', Rule::in(['public', 'private'])],
        ]);

        $quiz->title = $request->title;
        $quiz->password = $request->password;
        $quiz->name = $request->name;
        $quiz->status = $request->status;

        if ($quiz->save()) {
            return response()->json(['message' => 'Successfully Inserted!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot add Quiz'])->setStatusCode(400);
    }

    public function destroy($id)
    {
        $quiz = $this->returnUnique($id);
        if ($quiz->delete()) {
            return response()->json(['message' => 'Successfully Deleted!'])->setStatusCode(200);
        }

        return response()->json(['message' => 'Error, cannot delete order'])->setStatusCode(400);
    }
}
