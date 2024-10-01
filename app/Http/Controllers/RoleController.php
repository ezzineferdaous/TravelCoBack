<?php

namespace App\Http\Controllers;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure this line is present

class RoleController extends Controller
{
   // Fetch all roles
   public function index()
    {
        return RoleModel::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        // Create a new role with the validated data
        $role = RoleModel::create([
            'nom' => $validatedData['nom'],
        ]);

        // Return a response (can be JSON or a redirect depending on the use case)
        return response()->json($role, 201);
    }

    public function destroy($id)
    {
        $role = RoleModel::findOrFail($id);
        $role->delete();
        return response()->json($role, 201);
    }
}
