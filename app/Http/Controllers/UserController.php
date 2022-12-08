<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Inscription
    public function signin(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $userData = $request->validate([
            "siret" => ["required", "string", "regex:/\b\d{14}\b/"],
            "firstname" => ["required", "string", "min:3", "max:23"],
            "lastname" => ["required", "string", "min:3", "max:23"],
            "email" => ["required", "email", "unique:veterinaire,email"],
            "pwd" => ["required", "string", "min:8"],
            "matchPwd" => ["required", "string", "min:8", "same:pwd"]
        ]);

        $user = User::create([
            "siret" => $userData["siret"],
            "firstname" => $userData["firstname"],
            "lastname" => $userData["lastname"],
            "email" => $userData["email"],
            "pwd" => bcrypt($userData["pwd"]),
        ]);

        return response($user, 201);
    }

    //Connexion
    public function login(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $userData = $request->validate([
            "email" => ["required", "email"],
            "pwd" => ["required", "string", "min:8"]
        ]);

        $user = User::where("email", $userData["email"])->first();
        if (!$user) return response(["message" => "aucun utilisateur de trouver avec l'email suivant $userData[email]"], 401);
        if (!Hash::check($userData["pwd"], $user->pwd)) {
            return response(["message" => "le mot de passe ne correspond pas"], 401);
        }

        //Création d'un token d'authentification
        $token = $user->createToken("SECRET_KEY")->plainTextToken;

        return response([
            "user" => $user,
            "token" => $token
        ], 200);
    }
}
