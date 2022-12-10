<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //Ajouter un nouveau client
    public function addNewClient(Request $request)
    {
        // return 'hello';

        try {
            $request->headers->set('Accept', 'application/json');
            $clientData = $request->validate([
                "firstname" => ["required", "string", "min:3", "max:23"],
                "lastname" => ["required", "string", "min:3", "max:23"],
                "address" => ["required", "string"],
                "email" => ["required", "email", "unique:clients,email"],
                "phone" => ["required", "string"],
                "pwd" => ["required", "string", "min:8"],
                "veterinary_id" => ["required"]
            ]);

            $client = Client::create([
                "firstname" => $clientData["firstname"],
                "lastname" => $clientData["lastname"],
                "address" => $clientData["address"],
                "email" => $clientData["email"],
                "phone" => $clientData["phone"],
                "pwd" => $clientData["pwd"],
                "veterinary_id" => $clientData["veterinary_id"]
            ]);
            return response($client, 201);
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }
}
