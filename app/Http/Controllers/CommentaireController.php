<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentaireModel;
use App\Http\Controllers\Controller; 

class CommentaireController extends Controller
{
    // Get all commentaires
    public function index()
    {
        $commentaires = CommentaireModel::with(['utilisateur', 'vole'])->get();
        return response()->json($commentaires);
    }

    // Store a new commentaire
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'vole_id' => 'required|exists:voles,id',
            'message' => 'required|string',
            'date_comm' => 'nullable|date',
        ]);

        $commentaire = CommentaireModel::create($validatedData);

        return response()->json($commentaire, 201);
    }

    // PROFILE
    // Display commentaires by a specific user
    public function displayByUser($utilisateur_id)
    {
        $commentaires = CommentaireModel::with(['utilisateur', 'vole'])
            ->where('utilisateur_id', $utilisateur_id)
            ->get();

        return response()->json($commentaires);
    }
     // Display commentaires by a specific vol
    public function displayByVol($vol_id)
    {
        $commentaires = CommentaireModel::with(['utilisateur', 'vole'])
            ->where('vole_id', $vol_id)
            ->get();
 
        return response()->json($commentaires);
    }
    public function getUserComments($userId)
    {
         // Get all COMMENTS for the specific user with the associated voles
        $commentaires = CommentaireModel::with('vole.destination') // Include voles and their destinations
            ->where('utilisateur_id', $userId)
            ->get();
        return response()->json($commentaires);
    }
 
}
