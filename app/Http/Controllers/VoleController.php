<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VoleModel;
use App\Http\Controllers\Controller; 

class VoleController extends Controller
{
    //
    public function index()
    {
        return VoleModel::with('destination')->get(); // Fetch utilisateurs with their roles
    }

    // AFFICHAGE
    public function show($id)
    {
        $vole = VoleModel::find($id);

        if (!$vole) {
            return response()->json(['message' => 'Vole not found'], 404);
        }

        return response()->json($vole);
    }
    // ADD
    public function store(Request $request)
    {   
        // \Log::info('Request Data:', $request->all());
        // Validate the request data
        $validatedData = $request->validate([
            'ville' => 'required|string|max:255',
            'description' => 'required|string',
            'du' => 'required|date',
            'au' => 'required|date',
            'prix' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validate the image
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Create a unique name for the image
            $image->move(public_path('images'), $imageName); // Move the image to the public/images directory
            $validatedData['image'] = $imageName; // Store the image name in the database
        }

        // Create the new Vole record
        $vole = VoleModel::create($validatedData);

        return response()->json($vole, 201);
    }

    /*public function update(Request $request, $id)
    {
        // Log request data for debugging
        \Log::info('Request Data:', $request->all());
    
        // Validate incoming data
        $validatedData = $request->validate([
            'ville' => 'required|string|max:255',
        'destination_id' => 'required|exists:destinations,id',
        'description' => 'required|string',
        'du' => 'required|date_format:Y-m-d',
        'au' => 'required|date_format:Y-m-d',
        'prix' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Find the existing Vole record
        $vole = VoleModel::findOrFail($id);
    
        // Log the found Vole record
        \Log::info('Vole Record:', $vole->toArray());
    
        // Handle image update if a new image is provided
       
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
    
            $vole->image = $imageName;
        
    
        $vole->ville = $request->input('ville');
        $vole->description = $request->input('description');
        $vole->du = $request->input('du');
        $vole->au = $request->input('au');
        $vole->prix = $request->input('prix');
        $vole->destination_id = $request->input('destination_id');

        $vole->save();

    
        \Log::info('Updated Vole Record:', $vole->toArray());
    
        return response()->json($vole, 200);
    }*/
    
    public function update(Request $request, $id)
{
    // Log incoming data to check it   
    \Log::info('Request Data:', $request->all());
        // Validate the request data
        $validatedData = $request->validate([
            'ville' => 'required|string|max:255',
            'description' => 'required|string',
            'du' => 'required|date',
            'au' => 'required|date',
            'prix' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image
        ]);

        // Find the vole record
    $vole = VoleModel::findOrFail($id);

    // Handle the image upload
    /*if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Create a unique name for the image
        $image->move(public_path('images'), $imageName); // Move the image to the public/images directory
        $validatedData['image'] = $imageName; // Store the image name in the database
    }*/

    $vole->ville = $request->input('ville');
    $vole->description = $request->input('description');
    $vole->du = $request->input('du');
    $vole->au = $request->input('au');
    $vole->prix = $request->input('prix');
    $vole->destination_id = $request->input('destination_id');
        $vole->save();

        return response()->json($vole, 201);
}



    public function destroy($id)
    {
        $vole = VoleModel::findOrFail($id);
        $vole->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

   
}
