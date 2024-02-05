<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Animaux = Animal::all();
        return Response()->json($Animaux);
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
            'nom_animal.required' => 'Le champ nom est obligatoire.',
            'nom_animal.max' => 'Le champ nom est dépasse la taille max',
            'prix_animal.required' => 'Le champ prix est obligatoire.',
            'date_de_naissance_animal.required' => 'Le champ Date de naissance est obligatoire.',
            'type_animal.required' => 'Le champ Catégorie est obligatoire.',
            'couleur_animal.required' => 'Le champ Couleur est obligatoire.',
            'image_animal.mimes' => 'le champ photo doit être fichier de type:doc,docx,pdf,jpeg,jpg,png,gif',

        ];
        //
        $validator = Validator::make($request->all(), [
            'nom_animal' => ['required', 'max:100'],
            'prix_animal' => ['required'],
            'couleur_animal' => ['required'],
            'date_de_naissance_animal' => ['required'],
            'type_animal' => ['required'],
            'image_animal' => ['mimes:doc,docx,pdf,jpeg,jpg,png,gif|max:2048'],
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $filename = '';
        if (empty($request->file('image_animal'))) {
            $errors = array(
                'name' => array(
                    'Le champ image est obligatoire.',
                )
            );
            return response()->json(['errors' =>  $errors], 422);
        } else {
            $valueImage = $request->file('image_animal');
            $filename =  time() . "_" . $valueImage->getClientOriginalName();
            $valueImage->move('uploads', $filename);
        }

        $Animal = Animal::create([
            'nom_animal' => $request->nom_animal,
            'type_animal' => $request->type_animal,
            'couleur_animal' => $request->couleur_animal,
            'image_animal' => $filename,
            'date_de_naissance_animal' => $request->date_de_naissance_animal,
            'prix_animal' => $request->prix_animal,
        ]);
        return response()->json([
            'message' => 'Animal a été ajouté avec succès',
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        //
    }
}
