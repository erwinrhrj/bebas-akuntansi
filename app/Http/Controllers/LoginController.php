<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function username()
    {
        return 'pengguna_username';
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'pengguna_username' => 'required',
            'pengguna_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = request(['pengguna_username', 'pengguna_password']);
        if (! $token = Auth::attempt(['pengguna_username' => $credentials['pengguna_username'], 'password' => $credentials['pengguna_password'] ])) {
            return response()->json([
                'state' => false,
                'error' => 'Unauthorized'
            ], 401);
        }
        $pengguna = Pengguna::where('pengguna_username', $request->pengguna_username)
                ->first();

        return $this->createNewToken($token, $pengguna);
    }

    protected function createNewToken($token){
        return response()->json([
            'state' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    
}
