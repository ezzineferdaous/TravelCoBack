<?php

namespace App\Http\Controllers;
use App\Models\DestinationModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure this line is present

class DestinationController extends Controller
{
   // Fetch all roles
   public function index()
    {
        return DestinationModel::all();
    }

    public function store(Request $request)
    {
        $dest = DestinationModel::create($request->all());
        return response()->json($dest, 201);
    }
    
    public function destroy($id)
    {
        $dest = DestinationModel::findOrFail($id);
        $dest->delete();
        return response()->json($dest, 201);
    }
}
