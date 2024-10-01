<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ReserveModel;
use App\Http\Controllers\Controller; 
use Carbon\Carbon;

class ReserveController extends Controller
{
    // Method to display all reserves
    public function index()
    {
        $reserves = ReserveModel::with(['utilisateur', 'vole'])->get();
        return response()->json($reserves, 200);
    }

    // Method to store a new reserve
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'vole_id' => 'required|exists:voles,id',
            'Date_res' => 'required|date',
        ]);

        // Create a new reserve
        $reserve = ReserveModel::create([
            'utilisateur_id' => $validatedData['utilisateur_id'],
            'vole_id' => $validatedData['vole_id'],
            'Date_res' => $validatedData['Date_res'],
        ]);

        return response()->json($reserve, 201);
    }

    // Method to display reserves by user (utilisateur)
    public function displayByUser($utilisateur_id)
    {
        // Fetch reserves for the specified user
        $reserves = ReserveModel::where('utilisateur_id', $utilisateur_id)
                                ->with('vole')
                                ->get();

        return response()->json($reserves, 200);
    }

    public function getUserReservations($userId)
    {
        // Get all reservations for the specific user with the associated voles
        $reservations = ReserveModel::with('vole.destination') // Include voles and their destinations
            ->where('utilisateur_id', $userId)
            ->get();

        return response()->json($reservations);
    }
    //EN COURS
    public function getOngoingReservationsWithDetails()
    {
    // Get the current date
    $currentDate = Carbon::now();
    // \Log::info('Current Date: ' . $currentDate);

    // Fetch ongoing reservations with the related utilisateur, vole, and destination
    $reservations = ReserveModel::with(['utilisateur', 'vole.destination'])
        ->whereHas('vole', function ($query) use ($currentDate) {
            $query->where('du', '<=', $currentDate) // Filter for 'du' date less than current date
                  ->where('au', '>', $currentDate); // Filter for 'au' date greater than current date
        })
        ->get()
        ->groupBy('vole_id'); // Group by vole_id to count total reservations per vole
        \Log::info('vols: ' . $reservations);
    $result = [];

    foreach ($reservations as $voleId => $reserveGroup) {
        $totalReservations = $reserveGroup->count(); // Count total reservations for this vole
        \Log::info('Current Date: ' . $totalReservations);
        // Push the details into the result array, including vole_id, du, and au
        $result[] = [
            'vole_id' => $voleId,
            'vole' => $reserveGroup->first()->vole->ville,
            'destination' => $reserveGroup->first()->vole->destination->nom,
            'date_du' => $reserveGroup->first()->vole->du, // Include 'du' date
            'date_au' => $reserveGroup->first()->vole->au, // Include 'au' date
            'total_reservations' => $totalReservations,
            'reservations' => $reserveGroup->map(function ($reserve) {
                return [
                    'nom' => $reserve->utilisateur->nom,
                    'prenom' => $reserve->utilisateur->prenom,
                    'date_reservation' => $reserve->Date_res // Include the reservation date
                ];
            }),
        ];
    }

    return response()->json($result); // Return as JSON or pass to view
    }

    //EN ATTENT
    public function getOnwatingReservationsWithDetails()
    {
    // Get the current date
    $currentDate = Carbon::now();
    \Log::info('Current Date: ' . $currentDate);

    // Fetch ongoing reservations with the related utilisateur, vole, and destination
    $reservations = ReserveModel::with(['utilisateur', 'vole.destination'])
        ->whereHas('vole', function ($query) use ($currentDate) {
            $query->where('du', '>', $currentDate) // Filter for 'du' date less than current date
                  ->where('au', '>', $currentDate); // Filter for 'au' date greater than current date
        })
        ->get()
        ->groupBy('vole_id'); // Group by vole_id to count total reservations per vole
        // \Log::info('vols: ' . $reservations);
    $result = [];

    foreach ($reservations as $voleId => $reserveGroup) {
        $totalReservations = $reserveGroup->count(); // Count total reservations for this vole
        \Log::info('Current Date: ' . $totalReservations);
        // Push the details into the result array, including vole_id, du, and au
        $result[] = [
            'vole_id' => $voleId,
            'vole' => $reserveGroup->first()->vole->ville,
            'destination' => $reserveGroup->first()->vole->destination->nom,
            'date_du' => $reserveGroup->first()->vole->du, // Include 'du' date
            'date_au' => $reserveGroup->first()->vole->au, // Include 'au' date
            'total_reservations' => $totalReservations,
            'reservations' => $reserveGroup->map(function ($reserve) {
                return [
                    'nom' => $reserve->utilisateur->nom,
                    'prenom' => $reserve->utilisateur->prenom,
                    'date_reservation' => $reserve->Date_res // Include the reservation date
                ];
            }),
        ];
    }

    return response()->json($result); // Return as JSON or pass to view
    }


    //ARCHIV
    public function getArchivReservationsWithDetails()
    {
    // Get the current date
    $currentDate = Carbon::now();
    // \Log::info('Current Date: ' . $currentDate);

    // Fetch ongoing reservations with the related utilisateur, vole, and destination
    $reservations = ReserveModel::with(['utilisateur', 'vole.destination'])
        ->whereHas('vole', function ($query) use ($currentDate) {
            $query->where('du', '<', $currentDate) // Filter for 'du' date less than current date
                  ->where('au', '<', $currentDate); // Filter for 'au' date greater than current date
        })
        ->get()
        ->groupBy('vole_id'); // Group by vole_id to count total reservations per vole
        \Log::info('vols: ' . $reservations);
    $result = [];

    foreach ($reservations as $voleId => $reserveGroup) {
        $totalReservations = $reserveGroup->count(); // Count total reservations for this vole
        \Log::info('Current Date: ' . $totalReservations);
        // Push the details into the result array, including vole_id, du, and au
        $result[] = [
            'vole_id' => $voleId,
            'vole' => $reserveGroup->first()->vole->ville,
            'destination' => $reserveGroup->first()->vole->destination->nom,
            'date_du' => $reserveGroup->first()->vole->du, // Include 'du' date
            'date_au' => $reserveGroup->first()->vole->au, // Include 'au' date
            'total_reservations' => $totalReservations,
            'reservations' => $reserveGroup->map(function ($reserve) {
                return [
                    'nom' => $reserve->utilisateur->nom,
                    'prenom' => $reserve->utilisateur->prenom,
                    'date_reservation' => $reserve->Date_res // Include the reservation date
                ];
            }),
        ];
    }

    return response()->json($result); // Return as JSON or pass to view
    }
}
