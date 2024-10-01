<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\UtilisateurModel;
use App\Http\Controllers\Controller; // Ensure this line is present

class UtilisateurController extends Controller
{
    //
    public function index()
    {
        $utilisateurs = UtilisateurModel::with('role')->get();
    
        
    
        return response()->json($utilisateurs);
    }
    public function userById($id){
        $utilisateur = UtilisateurModel::findOrFail($id);

        return response()->json($utilisateur);
    }
    
    public function store(Request $request)
{   
    $validatedData = $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => 'required|email|unique:utilisateurs',
        'tel' => 'required|string',
        'date_naissance' => 'required|date',
        'password' => 'required|string', // No hashing here
        'role_id' => 'required|exists:roles,id',
    ]);
    
    $utilisateur = UtilisateurModel::create([
        'nom' => $validatedData['nom'],
        'prenom' => $validatedData['prenom'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']), // Store in plain text
        'tel' => $validatedData['tel'],
        'date_naissance' => $validatedData['date_naissance'],
        'role_id' => $validatedData['role_id'],
    ]);    

    return response()->json($utilisateur, 201);
}

    
    public function update(Request $request, $id)
    {
        \Log::info('Request Data:', $request->all());

        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email,'.$id, // Allow updating same email
            'tel' => 'required|string',
            'date_naissance' => 'required|date',
            'password' => 'string', // Make password nullable for updates
            'role_id' => 'exists:roles,id',
        ]);
        
        \Log::info('Request Data:', $request->all());
        $utilisateur = UtilisateurModel::findOrFail($id);
       
        
        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->email = $request->email;
        $utilisateur->tel = $request->tel;
        $utilisateur->date_naissance = $request->date_naissance;
        if($request->role_id == null){
            $utilisateur->role_id = 2;
        }
        else{
            $utilisateur->role_id = $request->role_id;
        }
        if($request->password != null){
            $utilisateur->password = Hash::make($validatedData['password']);
        }
        $utilisateur->save();
        \Log::info('Request Data:', $request->all());

        return response()->json($utilisateur, 200);

    }

    public function destroy($id)
    {
        $utilisateur = UtilisateurModel::findOrFail($id);
        $utilisateur->delete();
        return response()->json(['message' => 'Utilisateur deleted successfully']);
    }

    public function updateById(Request $request, $id)
    {
        \Log::info('Request Data:', $request->all());

        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email,'.$id, // Allow updating same email
            'tel' => 'required|string',
            'date_naissance' => 'required|date',
            'password' => 'string', // Make password nullable for updates
        ]);
        
        \Log::info('Request Data:', $request->all());
        $utilisateur = UtilisateurModel::findOrFail($id);
       
        
        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->email = $request->email;
        $utilisateur->tel = $request->tel;
        $utilisateur->date_naissance = $request->date_naissance;
        $utilisateur->role_id = 2;
        if($request->password != null){
            $utilisateur->password = Hash::make($validatedData['password']);
        }
        $utilisateur->save();
        \Log::info('Request Data:', $request->all());

        return response()->json($utilisateur, 200);

    }
}
