<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\VoleController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\CommentaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Routes accessible without logging in



use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Reservation
        Route::get('/reserves/user/{id}', [ReserveController::class, 'getUserReservations']);
        Route::post('/reserves', [ReserveController::class, 'store']);
        Route::get('/reserves', [ReserveController::class, 'index']);
        Route::get('/volencours', [ReserveController::class, 'getOngoingReservationsWithDetails']);
        Route::get('/volenattent', [ReserveController::class, 'getOnwatingReservationsWithDetails']);
        Route::get('/volarchiv', [ReserveController::class, 'getArchivReservationsWithDetails']);

        //Commantaire
        Route::post('/commentaire', [CommentaireController::class, 'store']);
        Route::get('/commentaire/user/{id}', [CommentaireController::class, 'getUserComments']);
        Route::get('/commentaire/vol/{id}', [CommentaireController::class, 'displayByVol']);
        Route::get('/commentaire', [CommentaireController::class, 'index']);

        //Role
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
        //Utilisateur
        Route::get('/utilisateurs', [UtilisateurController::class, 'index']);
        Route::post('/utilisateurs', [UtilisateurController::class, 'store']);
        Route::put('/utilisateurs/{id}', [UtilisateurController::class, 'update']);
        Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy']);
        Route::put('/user/{id}', [UtilisateurController::class, 'updateById']);
        Route::get('/user/{id}', [UtilisateurController::class, 'userById']);
        //Destination
        Route::post('/destination', [DestinationController::class, 'store']);
        Route::get('/destination', [DestinationController::class, 'index']);
        Route::delete('/destination/{id}', [DestinationController::class, 'destroy']);
        //Vole
        Route::get('/voles', [VoleController::class, 'index']);
        Route::get('/voles/details/{id}', [VoleController::class, 'show']);
        Route::post('/voles', [VoleController::class, 'store']);
        Route::put('/voles/{id}', [VoleController::class, 'update']);
        Route::delete('/voles/{id}', [VoleController::class, 'destroy']);
        Route::get('/voles/inprogress', [VoleController::class, 'getInProgressVoles']);
        Route::get('/voles/inatt', [VoleController::class, 'getInAttVoles']);

        //Reservation
        //Commantaire
   



// routes/api.php








