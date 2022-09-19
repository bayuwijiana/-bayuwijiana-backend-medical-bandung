<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = FacadesJWTAuth::attempt($credentials)) {
                return ApiFormatter::createApi(400, 'invalid credensial');
            }
        } catch (JWTException $e) {
            return ApiFormatter::createApi(500, 'could_not_create_token');
        }

        return ApiFormatter::createApi(200, 'token-type bearer', $token);
    }

    public function register(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:5',
            ]);
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            $token = FacadesJWTAuth::fromUser($user);
            return ApiFormatter::createApi(200, 'Succes Registered', $token);
        } catch (Exception $error) {
            $nounc = $error->getMessage();

            return ApiFormatter::createApi(400, $nounc);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
