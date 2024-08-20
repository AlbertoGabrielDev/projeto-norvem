<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
      
        $credentials = $request->only('email', 'password', 'id_unidade_fk', 'status');
        $user = User::where('email', $credentials['email'])->first();
            if ($user && Hash::check($request->password, $user->password) && $credentials['status'] == 1) {
                if ($user->id_unidade_fk == $credentials['id_unidade_fk']) {
                    Auth::login($user);
                    $token = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'token' => $token,
                        'user' => $user
                    ]);
                }
            }

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Login ou senha errado!'], 401);
            }
            if ($credentials['status'] == 0) {
                return response()->json(['error' => 'Usuario desabilitado! Falei com um administrador'], 401);
            }

            if ($user->id_unidade_fk != $credentials['id_unidade_fk']) {
                return response()->json(['error' => 'Unidade não pertence a este usuário'], 401);
            }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }
}
