<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAnimalsOfOneVeterinary($id)
    {
        //Récupérer tous les animaux d'un vétérinaire
        try {
            $animals = DB::table("animals")
                ->join("veterinaire", "animals.veterinary_id", "=", "veterinaire.id")
                ->select("animals.*")
                ->where("animals.veterinary_id", "=", $id)
                ->get();

            return $animals;
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    public function getAllAnimalsOfOneClient($id)
    {
        //Récupérer tous les animaux d'un client
        try {
            $animals = DB::table("animals")
                ->join("clients", "animals.client_id", "=", "clients.id")
                ->select("animals.*")
                ->where("animals.client_id", "=", $id)
                ->get();

            return $animals;
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    public function getOneAnimal(Animal $id)
    {
        try {
            $animal = Animal::find($id)->last();
            // $client = Client::where('id', $id)->get();
        } catch (Exception $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
        return $animal;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addNewAnimal(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');
            $animalData = $request->validate([
                "name" => ["required", "string", "min:3", "max:23"],
                "type" => ["required", "string"],
                "date_of_birth" => ["required", "date"],
                "sexe" => ["required", "string"],
                "weight" => ["required", "string"],
                "size" => ["required", "string"],
                "veterinary_id" => ["required"],
                "client_id" => ["required"]
            ]);

            $animal = Animal::create([
                "name" => $animalData["name"],
                "type" => $animalData["type"],
                "date_of_birth" => $animalData["date_of_birth"],
                "sexe" => $animalData["sexe"],
                "weight" => $animalData["weight"],
                "size" => $animalData["size"],
                "veterinary_id" => $animalData["veterinary_id"],
                "client_id" => $animalData["client_id"]
            ]);

            return response($animal, 201);
        } catch (Error $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnimalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnimalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnimalRequest  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function deleteAnimal(Request $request, $id)
    {
        //
        try {
            $animalValidation = $request->validate([
                "veterinary_id" => ["required", "numeric"]
            ]);

            $animal = Animal::find($id);
            if (!$animal) {
                return response(["message" => "aucune voiture de trouver avec cet id $id"], 404);
            } elseif ($animal->veterinary_id !== $animalValidation["veterinary_id"]) {
                return response(["message" => "action interdite"], 403);
            }

            Animal::destroy($id);
            return response(["message" => "animal supprimé"], 200);
        } catch (Error $e) {
            echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
        }
    }
}
