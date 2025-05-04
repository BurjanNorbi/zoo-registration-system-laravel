<?php

namespace App\Http\Controllers;

use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnclosureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->admin) {
            $enclosures = Enclosure::query();
        } else {
            $enclosures = Auth::user()->enclosures();
        }

        $enclosures = $enclosures
                            ->orderBy('name')
                            ->paginate(5);

        return view('enclosures.enclosures', ['enclosures' => $enclosures]);
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

        return view('enclosures.enclosureform');
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

        $enclosure = Enclosure::create($validated);

        return redirect()->route('enclosures.show', ['enclosure' => $enclosure->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enclosure = Enclosure::findOrFail($id);

        // Authorization
        if(!$enclosure->users->contains(Auth::id()) && !Auth::user()->admin)
        {
            abort(403);
        }

        return view('enclosures.enclosure', ['enclosure' => $enclosure]);
    }

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

        $enclosure = Enclosure::findOrFail($id);
        $users = User::all();

        return view('enclosures.enclosureform', ['enclosure' => $enclosure, 'users' => $users]);
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

        $enclosure = Enclosure::findOrFail($id);

        $validated = $this->validateUpdate($request);

        $enclosure->update($validated);

        $enclosure->users()->sync($validated['caregivers'] ?? []);

        return redirect()->route('enclosures.show', ['enclosure' => $id]);
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

        $enclosure = Enclosure::findOrFail($id);

        if($enclosure->animals()->count() > 0) {
            abort(400, 'A törlendő kifutó nem üres!');
        }

        $enclosure->delete();

        return redirect()->route('enclosures.index');
    }

    private function validateStore(Request $request) {
        return $request->validate([
            'name' => 'required|string|min:5|max:100',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
        ], [
            'name.required' => 'A kifutó neve kötelező.',
            'name.string' => 'A kifutó neve szöveg típusú kell legyen.',
            'name.min' => 'A kifutó neve legalább 5 karakter hosszú legyen.',
            'name.max' => 'A kifutó neve legfeljebb 100 karakter lehet.',

            'limit.required' => 'Az állatlétszám megadása kötelező.',
            'limit.integer' => 'Az állatlétszám szám típusú kell legyen.',
            'limit.min' => 'Az állatlétszámnak legalább 1-nek kell lennie.',

            'feeding_at.required' => 'Az etetési idő megadása kötelező.',
            'feeding_at.date_format' => 'Az etetési idő formátuma HH:MM (24 órás) kell legyen.',
        ]);
    }

    private function validateUpdate(Request $request) {
        return $request->validate([
            'name' => 'required|string|min:5|max:100',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
            'caregivers' => 'nullable|array',
            'caregivers.*' => 'exists:users,id',
        ], [
            'name.required' => 'A kifutó neve kötelező.',
            'name.string' => 'A kifutó neve szöveg típusú kell legyen.',
            'name.min' => 'A kifutó neve legalább 5 karakter hosszú legyen.',
            'name.max' => 'A kifutó neve legfeljebb 100 karakter lehet.',

            'limit.required' => 'Az állatlétszám megadása kötelező.',
            'limit.integer' => 'Az állatlétszám szám típusú kell legyen.',
            'limit.min' => 'Az állatlétszámnak legalább 1-nek kell lennie.',

            'feeding_at.required' => 'Az etetési idő megadása kötelező.',
            'feeding_at.date_format' => 'Az etetési idő formátuma HH:MM (24 órás) kell legyen.',

            'caregivers.array' => 'A gondozók listájának tömbnek kell lennie.',
            'caregivers.*.exists' => 'A kiválasztott gondozó nem létezik az adatbázisban.',
        ]);
    }
}
