<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Commandes = Commande::get();
        return Response()->json($Commandes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userId = Auth()->user()->id;

        $commande = Commande::create([
            'user_id' => $userId,
            'NumCommande' =>  $this->generateNumberCommande('Commande'),
            'status' => "non-paye",
        ]);

        return response()->json($commande->id);
    }
    public function generateNumberCommande($char)
    {
        $currentDateTimeString = date('M d, H:i:s');
        $dateTime = new DateTime($currentDateTimeString);
        $timestamp = $dateTime->getTimestamp();
        $year = date('Y');
        $NumberCommande = $char . $year . $timestamp;
        return $NumberCommande;
    }

    public function checkcommandesstatus()
    {
        // Retrieve the count of commands with the status "non-paye"
        $countNonPaye = Commande::where("user_id", "=", Auth()->user()->id)
            ->where("status", "=", "non-paye")
            ->count();

        // Retrieve the ID of the last command added with status "non-paye"
        $lastNonPayeCommande = Commande::where("user_id", "=", Auth()->user()->id)
            ->where("status", "=", "non-paye")
            ->latest()
            ->value('id');

        return response()->json([
            "countNonPaye" => $countNonPaye,
            "lastNonPayeCommandeID" => $lastNonPayeCommande,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    public function updateToPaye()
    {
        try {
            // Retrieve the last non-paye commande for the authenticated user
            $lastNonPayeCommande = Commande::where("user_id", "=", Auth()->user()->id)
                ->where("status", "=", "non-paye")
                ->latest()
                ->first(); // Retrieve the actual model instance
            
            if ($lastNonPayeCommande) {
                // Update the status to paye
                $lastNonPayeCommande->status = 'paye';
                $lastNonPayeCommande->save();
    
                // Return a success response
                return response()->json(['message' => 'Commande mise à jour au statut payant'], 200);
            } else {
                // Return an error response if no non-paye commande is found
                return response()->json(['error' => 'Aucune commande non payée trouvée'], 404);
            }
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => "Échec de la mise à jour de l'état de la commande"], 500);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
