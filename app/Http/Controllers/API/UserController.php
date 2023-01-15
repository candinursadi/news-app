<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    function login() {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token = $user->createToken('newsApp');
            $expires_in = Carbon::parse($token->token->expires_at)->timestamp - Carbon::parse($token->token->created_at)->timestamp;

            return response()->json([
                'access_token' => $token->accessToken,
                'expires_in' => $expires_in
            ], 200);
        }else{
            return response()->json([
                'error' => 'Incorrect email or password'
            ], 400);
        }
    }

    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $input = $request->all();
        $input['is_admin'] = $request->is_admin == "true" ? 1 : 0;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $token = $user->createToken('newsApp');
        $expires_in = Carbon::parse($token->token->expires_at)->timestamp - Carbon::parse($token->token->created_at)->timestamp;

        return response()->json([
            'access_token' => $token->accessToken,
            'expires_in' => $expires_in,
            'data' => $user
        ], 200);
    }

    function detail() {
        return response()->json([
            'data' => Auth::user()
        ], 200);
    }
}
