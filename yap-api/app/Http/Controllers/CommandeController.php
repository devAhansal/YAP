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

    public function updateAllToPaye()
    {
        try {
            // Retrieve all commandes
            $commandes = Commande::all();

            // Loop through each commande and update its status to "paye"
            foreach ($commandes as $commande) {
                $commande->status = 'paye';
                $commande->save();
            }
    
            // Return a success response
            return response()->json(['message' => 'All commandes updated to status paye'], 200);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => "Failed to update commandes status"], 500);
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
