<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(UserRegisterRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $data = [
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];

            return sendHttpResponse('User registered', Response::HTTP_CREATED, $data);

        }catch(Exception $exception){
            return sendHttpResponse('Failed to register user', $exception->getCode(), null, $exception);
        }
       
        
    }

    /**
     * Login a user
     */
    public function login(UserLoginRequest $request)
    {
        try{
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $data = [
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];

            return sendHttpResponse('User logged in', Response::HTTP_CREATED, $data);

        }catch(Exception $exception){
            return sendHttpResponse('Failed to login user', $exception->getCode(), null, $exception);

        }
        
    }

    /**
     * Logout a user
     */
    public function logout(Request $request)
    {
        try{
            $request->user()->tokens()->delete();

            return sendHttpResponse('User Lgogged Out', Response::HTTP_OK);

        } catch (Exception $exception) {
            return sendHttpResponse('Failed to logout', $exception->getCode(), null, $exception);
        }
        
    } 
}
