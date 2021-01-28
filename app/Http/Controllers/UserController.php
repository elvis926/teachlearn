<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\User as UserResource;


class UserController extends Controller
    {
    private static $messages = [
        'required'=>'El compo: atribute es obligatorio',
    ];
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required',
            'phone'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            //'rol_type'=>'required|string',
            'role'=>'required|string',
            ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'last_name'=>$request->get('last_name'),
            'birthday'=>$request->get('birthday'),
            'phone'=>$request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            //'rol_type' => $request->get('rol_type'),
            'role'=>$request->get('role'),
            ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
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

    public function index()
    {
        $this->authorize('viewAny', User::class);
        return User::all();
    }
    public function show(User $user){
        $this->authorize('view', $user);
        return response()->json(new UserResource($user),200);
    }
    public function update(Request $request, User $user)
    {
        $this->authorize('update',$user);
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'phone'=> 'required|string',
        ],self::$messages);

        $user->update($request->all());
        return response()->json($user, 200);
    }
    public function delete(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        return response()->json(null, 204);
    }
    }
