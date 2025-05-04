@extends('layouts.layout')

@section('title', 'Főoldal')

@section('content')
    <h1 class="ps-3">Szia {{ Auth::user()->name }}!</h1>
    <div class="ps-3">
        <p>Kifutók száma: {{ $enclosureCount }}</p>
        <p>Állatok száma: {{ $animalCount }}</p>
    </div>
    <h2 class="ps-3">Teendők</h2>
    <hr />
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th style="width: 50%">Kifutó neve</th>
                    <th style="width: 50%">Etetési idő</th>
                </tr>
            </thead>
            <tbody class="text-center">

                @foreach ($enclosures as $enclosure)
                    {{-- @dd($enclosure) --}}
                    <tr>
                        <td>{{ $enclosure->name }}</td>
                        <td>{{ $enclosure->feeding_at->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- {{ $enclosures->links() }} --}}
    </div>
@endsection
