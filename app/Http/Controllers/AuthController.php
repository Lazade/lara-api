<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    protected function register(Request $request) {
        $validator = Validator::make($request->all(), User::createRules());
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response = [
                'error' => 'Invalidated data',
                'message' => $errors
            ];
            return response()->json($response);
        }
        $validated = $validator->validated();
        $preData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ];
        $newUser = User::create($preData);

        $token = $newUser->createToken('myapptoken')->plainTextToken;

        $response = [
            'data' => [
                'user' => $newUser,
                'token' => $token
            ]
        ];
        return response()->json($response);
    }

    protected function login(Request $request) {
        $fields = $request->all();
        try {
            $user = User::where('email', $fields['email'])->first();
        } catch (\Throwable $th) {
            $response = [
                'error' => 'Error',
                'message' => $th
            ];
            return response()->json($response);
        }
        if (!$user) {
            $response = [
                'error' => 'Login Fail',
                'message' => 'email('.$fields['email'].') did not be registered'
            ];
            return response()->json($response);
        }
        if (!Hash::check($fields['password'], $user->password)) {
            $response = [
                'error' => 'Login Fail',
                'message' => 'Password was not matched'
            ];
            return response()->json($response);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'message' => 'Login Succeeded',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
        return response()->json($response);
    }

    protected function logout(Request $request) {
        $user = $request->user();
        if (!$user) {
            $response = [
                'error' => 'Fail',
                'message' => 'Could not retrieve the current user'
            ];
            return response()->json($response);
        }
        $result = $user->tokens()->delete();
        // var_dump($result);
        $response = [
            'message' => 'Logout succeeded',
            'data' => $user
        ];
        return response()->json($response);
    }
}
