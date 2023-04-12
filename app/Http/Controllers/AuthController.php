<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::all()->where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Credentials doesnt match our record'], 401);
        }

        return [
            'message'=>"Succesfully Logged in!",
            'token' => $user->createToken('login')->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return [
                'message' => 'Successfully logged out!'
            ];
        }
    }

    public function register(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'firstName' => 'required',
                    'lastName' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = new User;

            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->school = $request->school;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if ($user->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'token' => $user->createToken("login")->plainTextToken
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
