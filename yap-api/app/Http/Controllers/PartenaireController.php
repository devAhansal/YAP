<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;


class PartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Partenaire = User::where("type", "=", 2)->get();
        return Response()->json($Partenaire);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Le champ Nom est obligatoire.',
            'name.max' => 'Le champ Nom est dépasse la taille max',
            'date_de_naissance.required' => 'Le champ Date de naissance est obligatoire.',
            'carte_identite.required' => 'Le champ Carte est obligatoire.',
            'carte_identite.max' => 'Le champ Carte est dépasse la taille max',
            'address.required' => 'Le champ Adresse est obligatoire.',
            'phone.required' => 'Le champ Téléphone est obligatoire.',
            'phone.max' => 'Le champ Téléphone est dépasse la taille max',
            'region.required' => 'Le champ Région est obligatoire.',
            'statu.required' => 'Le champ Statu est obligatoire.',
            'email.required' => 'Le champ E-mail est obligatoire.',
            'email.unique' => 'Le champ email a été utilise.',
            'password.min' => 'Le champ mot de passe est inférieur à la taille minimale',
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100'],
            'date_de_naissance' => ['required'],
            'carte_identite' => ['required','max:100'],
            'address' => ['required'],
            'phone' => ['required', 'max:100'],
            'region' => ['required'],
            'statu' => ['required'],
            'email' => ['required','unique:users'],
            'password' => ['min:8'],
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
       if($request->statu == "false"){
        $Partenaire = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' =>  Hash::make($request->password),
            'password_exact' => $request->password,
            'address' => $request->address,
            'region' => $request->region,
            'phone' => $request->phone,
            'date_de_naissance' => $request->date_de_naissance,
            'carte_identite' => $request->carte_identite,
            'type' => "partenaire",
            'statu' => 0,

        ]);}else{
            $Partenaire = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' =>  Hash::make($request->password),
                'password_exact' => $request->password,
                'address' => $request->address,
                'region' => $request->region,
                'phone' => $request->phone,
                'date_de_naissance' => $request->date_de_naissance,
                'carte_identite' => $request->carte_identite,
                'type' => 2,
                'statu' => 1,
    
            ]);}
        return response()->json([
            'message' => 'Partenaire a été ajouté avec succès',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
