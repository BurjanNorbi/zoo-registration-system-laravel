<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enclosures = Auth::user()->enclosures();
        $enclosureCount = $enclosures->count();
        $animalCount = 0;
        foreach($enclosures->get() as $enclosure) {
            $animalCount += $enclosure->animals->count();
        }

        $now = Carbon::now();
        $enclosures = $enclosures->whereTime('feeding_at', '>', $now->toTimeString())->orderBy('feeding_at')->get();

        return view('home', ['enclosures' => $enclosures, 'animalCount' => $animalCount, 'enclosureCount' => $enclosureCount]);
    }
}
