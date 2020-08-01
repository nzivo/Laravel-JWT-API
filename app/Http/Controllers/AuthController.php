<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if(!$token=auth()->attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Check your Credentials',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login Successful',
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Register a User
     */

    public function register(Request $request){
        $encryptedPassword = Hash::make($request->password);

        $user = new User;

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->occupation = $request->occupation;
            $user->institution = $request->institution;
            $user->password  = $encryptedPassword;

            $user->save();

            $role = Role::select('id')->where('name', 'user')->first();
            $user->roles()->attach($role);

            return $this->login($request);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'Registration Unsuccessful',
                'error' => ''.$e
            ]);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'Logout Successful'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Logout Unsuccessful',
                'error' => ''.$e
            ]);
        }
    }

}
