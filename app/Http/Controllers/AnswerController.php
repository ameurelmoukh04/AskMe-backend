<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::all();
        return response()->json([$answers],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(),[
            'content' => 'required|string|min:5'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'data not valide'],422);
        }
        $answer =Answer::create([
            'content' => $request->content,
            'user_id' => $user->id,
            'question_id' => $request->questionId
        ]);
        
        return response()->json(['message' => 'Answer Posted Succesfully','answer' =>$answer],201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $questionId)
    {
        $questionAnswers = Answer::where('question_id',$questionId)->with('user:id,name')->get();
        return response()->json($questionAnswers,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
