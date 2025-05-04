<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $animals = Animal::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('animals.animals', ['animals' => $animals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $enclosures = Enclosure::all();

        return view('animals.animalform', ['enclosures' => $enclosures]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $validated = $this->validateStore($request);

        if($request->hasFile('image')) {
            $filename = $request->file('image')->store();
            $validated['imagename'] = $request->file('image')->getClientOriginalName();
            $validated['imagename_hash'] = $filename;
        }

        $animal = Animal::create($validated);

        return redirect()->route('enclosures.show', ['enclosure' => $animal->enclosure]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $animal = Animal::withTrashed()->findOrFail($id);
        $enclosures = Enclosure::all();

        return view('animals.animalform', ['animal' => $animal, 'enclosures' => $enclosures]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $animal = Animal::withTrashed()->findOrFail($id);

        $validated = $this->validateUpdate($request, $id);

        if($animal->deleted_at != null) {
            $animal->restore();
        }

        if($request->hasFile('image')) {
            if($animal->imagename != null) {
                // check if image is seeded
                if(!str_contains($animal->imagename_hash, 'image.jpg')) {
                    Storage::disk('public')->delete($animal->imagename_hash);
                }
            }
            $filename = $request->file('image')->store();
            $validated['imagename'] = $request->file('image')->getClientOriginalName();
            $validated['imagename_hash'] = $filename;
        }

        $animal->update($validated);

        return redirect()->route('enclosures.show', ['enclosure' => $animal->enclosure]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Authorization
        if(!Auth::user()->admin)
        {
            abort(403);
        }

        $animal = Animal::findOrFail($id);

        $enclosure = $animal->enclosure;

        $animal->update(['enclosure_id' => null]);

        $animal->delete();

        return redirect()->route('enclosures.show', ['enclosure' => $enclosure]);
    }

    private function validateStore(Request $request) {
        return $request->validate([
            'name' => 'required|string|min:5|max:100',
            'species' =>'required|string|min:5|max:100',
            'is_predator' => 'required|in:0,1',
            'born_at' => 'required|date|before_or_equal:today',
            'enclosure_id' =>[
                'required',
                'exists:enclosures,id',
                function ($attribute, $value, $fail) {
                    $enclosure = Enclosure::find($value);
                    if(!$enclosure || $enclosure->animals()->count() >= $enclosure->limit) {
                        $fail('Ez a kifutó tele van!');
                    }
                },
                function ($attribute, $value, $fail) use($request){
                    $enclosure = Enclosure::find($value);
                    $isPredator = $request->input('is_predator') === '1';
                    if(!$enclosure || $enclosure->arePredators() != $isPredator) {
                        $fail('Ragadozó és nem ragadozó állat nem kerülhet ugyanabba a kifutóba!');
                    }
                }
            ],
            'image' =>'nullable|image',
        ], [
            'name.required' => 'Az állat neve kötelező.',
            'name.string' => 'Az állat neve szöveg típusú kell legyen.',
            'name.min' => 'Az állat neve legalább 5 karakter hosszú legyen.',
            'name.max' => 'Az állat neve legfeljebb 100 karakter lehet.',

            'species.required' => 'A faj megadása kötelező.',
            'species.string' => 'A faj neve szöveg típusú kell legyen.',
            'species.min' => 'A faj neve legalább 5 karakter hosszú legyen.',
            'species.max' => 'A faj neve legfeljebb 100 karakter lehet.',

            'is_predator.required' => 'Kérlek válaszd ki, hogy az állat ragadozó-e.',
            'is_predator.in' => 'Érvénytelen választás a ragadozósághoz.',

            'born_at.required' => 'A születési dátum megadása kötelező.',
            'born_at.date' => 'A születési dátum érvényes dátum kell legyen.',
            'born_at.before_or_equal' => 'A születési dátum nem lehet a jövőben.',

            'enclosure_id.required' => 'A kifutó megadása kötelező.',
            'enclosure_id.exists' => 'A kiválasztott kifutó nem létezik.',

            'image.image' => 'A feltöltött fájl nem érvényes képformátum.',
        ]);
    }

    private function validateUpdate(Request $request, string $id) {
        return $request->validate([
            'name' => 'required|string|min:5|max:100',
            'species' =>'required|string|min:5|max:100',
            'is_predator' => 'required|in:0,1',
            'born_at' => 'required|date|before_or_equal:today',
            'enclosure_id' =>[
                'required',
                'exists:enclosures,id',
                function ($attribute, $value, $fail) use($id) {
                    $enclosure = Enclosure::find($value);
                    $inside = $enclosure != null && $enclosure->animals()->find($id) != null;
                    if(!$inside && (!$enclosure || $enclosure->animals()->count() >= $enclosure->limit)) {
                        $fail('Ez a kifutó tele van!');
                    }
                },
                function ($attribute, $value, $fail) use($request, $id){
                    $enclosure = Enclosure::find($value);
                    $isPredator = $request->input('is_predator') === '1';
                    $singleton = $enclosure != null && $enclosure->animals()->count() == 1 && $enclosure->animals()->find($id) != null;
                    if(!$singleton && (!$enclosure || $enclosure->arePredators() != $isPredator)) {
                        $fail('Ragadozó és nem ragadozó állat nem kerülhet ugyanabba a kifutóba!');
                    }
                }
            ],
            'image' =>'nullable|image',
        ], [
            'name.required' => 'Az állat neve kötelező.',
            'name.string' => 'Az állat neve szöveg típusú kell legyen.',
            'name.min' => 'Az állat neve legalább 5 karakter hosszú legyen.',
            'name.max' => 'Az állat neve legfeljebb 100 karakter lehet.',

            'species.required' => 'A faj megadása kötelező.',
            'species.string' => 'A faj neve szöveg típusú kell legyen.',
            'species.min' => 'A faj neve legalább 5 karakter hosszú legyen.',
            'species.max' => 'A faj neve legfeljebb 100 karakter lehet.',

            'is_predator.required' => 'Kérlek válaszd ki, hogy az állat ragadozó-e.',
            'is_predator.in' => 'Érvénytelen választás a ragadozósághoz.',

            'born_at.required' => 'A születési dátum megadása kötelező.',
            'born_at.date' => 'A születési dátum érvényes dátum kell legyen.',
            'born_at.before_or_equal' => 'A születési dátum nem lehet a jövőben.',

            'enclosure_id.required' => 'A kifutó megadása kötelező.',
            'enclosure_id.exists' => 'A kiválasztott kifutó nem létezik.',

            'image.image' => 'A feltöltött fájl nem érvényes képformátum.',
        ]);
    }
}
