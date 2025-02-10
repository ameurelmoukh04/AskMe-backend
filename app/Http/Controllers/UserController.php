<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'data not valide'], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['message' => 'registered Succesfully', 'user' => $user, 'token' => $token], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'credentials not valide'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'logged in succesfully',
            'user' => $user,
            'token' => $token
        ],200);
    }

    public function logout(Request $request){
        $user = Auth::user();

        if($user){
            $user->tokens()->delete();
            return response()->json(['message' => 'deleted succesfully'],200);
        }
        return response()->json(['message' => 'you are not Authenticated'],401);
    }
}
