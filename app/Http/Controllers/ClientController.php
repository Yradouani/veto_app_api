<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

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
        } catch (Error $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    //Récupérer tous les clients d'un vétérinaire donné
    public function getAllClientsOfOneVeterinary($id)
    {
        try {
            // $client = Client::where("veterinary_id", $id)->get();
            // $client = Client::whereHas("veterinary_id", $veterinary_id)->get();
            // $client = Client::find($id);


            $client = DB::table("clients")
                ->join("veterinaire", "clients.veterinary_id", "=", "veterinaire.id")
                ->select("clients.*")
                ->where("clients.veterinary_id", "=", $id)
                ->get();

            return $client;
            // return response($client, 201);
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    public function getOneClient(Client $id)
    {
        try {
            $client = Client::find($id)->last();
            // $client = Client::where('id', $id)->get();
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
        return $client;
    }

    public function deleteClient(Request $request, $id)
    {
        try {
            $request->headers->set('Accept', 'application/json');
            // $clientValidation = $request->validate([
            //     "id" => ["required"]
            // ]);

            $client = Client::find($id);
            if (!$client) {
                return response(["message" => "aucun client de trouver avec cet id $id"], 404);
            }
            // elseif ($client->veterinary_id !== $clientValidation["veterinary_id"]) {
            //     return response(["message" => "action interdite"], 403);
            // }

            Client::destroy($id);
            return response(["message" => "client supprimé"], 200);
        } catch (Error $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    public function getClientOfOneAnimal($id)
    {
    }
}
