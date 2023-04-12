<?php

use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::group(['namespace'=>'App\Http\Controllers','middleware'=>'auth:sanctum'],function(){
    Route::apiResource('quiz',QuizController::class);
});

Route::controller(QuestionController::class)->prefix('question')->group(function(){
    Route::get('all/{quiz_id}', 'get_all');
    Route::get('/{quiz_id}', 'get_specific');
    Route::post('/', 'create_question');
    Route::put('/{quiz_id}', 'update_question');
    Route::delete('/{quiz_id}', 'delete_question');
})->middleware('auth:sanctum');
