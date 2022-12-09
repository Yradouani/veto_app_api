<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
header('Access-Control-Allow-Credentials', true);

Route::post("/user/signin", [UserController::class, "signin"]);
Route::post("/user/login", [UserController::class, "login"]);

Route::get("/user/veterinary", [UserController::class, "getVeterinary"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
