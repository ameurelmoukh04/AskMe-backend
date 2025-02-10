<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/users',[UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware('auth:sanctum')->post('/questions',[QuestionController::class, 'store']);

Route::get('/questions', [QuestionController::class, 'index']);


Route::get('/questions/{questionId}/answers', [AnswerController::class,'show']);

Route::middleware('auth:sanctum')->post('/questions/{questionId}/answers', [AnswerController::class,'store']);
