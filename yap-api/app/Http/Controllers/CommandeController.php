<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Console\Command;

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
        $commande = Commande::create([
            'NumCommande' =>  $this->generateNumberCommande('Commande'),
            'status' => "non-paye",
            'user_id ' => Auth()->user()->id,
        ]);
        
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
