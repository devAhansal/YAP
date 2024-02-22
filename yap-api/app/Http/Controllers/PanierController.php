<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data if necessary
        $validatedData = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'animal_id' => 'required|exists:animals,id',
        ]);

        try {
            // Check if a record with the same combination of IDs already exists
            $existingPanier = Panier::where('commande_id', $validatedData['commande_id'])
                ->where('animal_id', $validatedData['animal_id'])
                ->first();

            if ($existingPanier) {
                // If the combination exists, you can handle it according to your application logic
                return response()->json(['error' => 'The combination already exists'], 400);
            }

            // Create a new Panier instance
            $panier = new Panier();

            // Assign the commande_id and animal_id from the request
            $panier->commande_id = $validatedData['commande_id'];
            $panier->animal_id = $validatedData['animal_id'];

            // Save the Panier instance
            $panier->save();

            // Return a success response
            return response()->json($panier, 201);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => "Échec de l'ajout d'un animal à la commande"], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function show(Panier $panier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function destroy($commandeId, $animalId)
    {
        try {
            // Find the panier entry based on the given commande_id and animal_id
            $panier = Panier::where('commande_id', $commandeId)
                ->where('animal_id', $animalId)
                ->first();

            if ($panier) {
                // Delete the found panier entry
                $panier->delete();

                // Return a success response
                return response()->json(['message' => 'Panier entry deleted successfully'], 200);
            } else {
                // Return an error response if the panier entry is not found
                return response()->json(['error' => 'Panier entry not found'], 404);
            }
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => 'Failed to delete panier entry'], 500);
        }
    }
}
