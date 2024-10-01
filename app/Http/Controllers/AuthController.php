<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UtilisateurModel;
class AuthController extends Controller
{
    //
    // Register
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs',
            'tel' => 'required|string',
            'date_naissance' => 'required|date',
            'password' => 'required|string',
        ]);

        $utilisateur = UtilisateurModel::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'tel' => ($validatedData['tel']),
            'date_naissance' => ($validatedData['date_naissance']),
            'role_id' => 2, // Default to 'client' role
        ]);

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $utilisateur,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Login
    // In the AuthController
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = UtilisateurModel::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create token for the user
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}

}
