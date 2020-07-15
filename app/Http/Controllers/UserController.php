<?php

namespace App\Http\Controllers;
use Auth;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Cookie;
use Tymon\JWTAuth\JWTGuard;

class UserController extends Controller
{
    public function authenticate(Request $request){

        $credentials = $request->only('username', 'password');

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Invalid Credentials'], 400);
            }

        }catch(JWTException $e){
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


        return response()->json(['success' => 'User successfully logged in'], 200)->cookie('token', $token, 45);
    }


    public function registration(Request $request){

        $validator = Validator::make($request->all(),[
            'username' => 'required|string|unique:users',
            'password' => array(
                'required',
                //'string',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/'
            )
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
                    'username' => $request->get('username'),
                    'password' => Hash::make($request->get('password'))
                ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);


    }

    public function getAuthenticatedUser()
    {
            try {

                    if (! $user = JWTAuth::parseToken()->authenticate()) {
                            return response()->json(['user_not_found'], 404);
                    }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                    return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json(['token_absent'], $e->getStatusCode());

            }

            return response()->json(compact('user'));
    }

    public function logout() {
        Auth::guard('api')->logout();
    
        return redirect('/')->with([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }



}
