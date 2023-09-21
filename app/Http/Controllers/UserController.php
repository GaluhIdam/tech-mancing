<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Get User Data
    public function index()
    {
        $data = User::all();
        return response()->json([
            'message' => 'Getting User Data is Successfully!',
            'status' => 200,
            'data' => $data
        ], 200);
    }

    //Register
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:5|max:20|unique:users',
                'email' => 'required|email|min:5|max:50|unique:users',
                'no_telp' => 'required|numeric|min:11|unique:users',
                'password' => 'required|min:6',
                're_password' => 'required|min:6|same:password',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Errors',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'role' => 'user',
            'username' => $request->get('username'),
            'no_telp' => $request->get('no_telp'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'message' => 'User has Created Successfully!',
            'data' => $user,
        ], 201);
    }

    //Login
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Errors',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                    $token = Auth::user()->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'message' => 'User Login has Successfully!',
                        'data' => $user,
                        'token' => $token,
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Login has Failed please cek your password!',
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'Login has Failed, please check your password!',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Login has Failed, please check your email!',
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();
        if ($removeToken) {
            return response()->json([
                'message' => 'User Logout has Successfully!',
            ], 200);
        }
    }
}
