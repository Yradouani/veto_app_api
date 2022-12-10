<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
header('Access-Control-Allow-Credentials', true);

//Routes d'inscription et connexion
Route::post("/user/signin", [UserController::class, "signin"]);
Route::post("/user/login", [UserController::class, "login"]);

//Route d'acces aux informations du vétérinaire connecté
Route::get("/user/veterinary/{id}", [UserController::class, "getOneVeterinary"]);

Route::get("/user/veterinary", [UserController::class, "getAllVeterinary"]);

//Route concernant les clients
Route::post("/user/client", [ClientController::class, "addNewClient"]);
Route::get("/user/client/{id}", [ClientController::class, "getOneClient"]);
Route::get("/user/clients", [ClientController::class, "getAllClients"]);
Route::get("user/veterinary/{id}/clients", [ClientController::class, "getAllClientsOfOneVeterinary"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
