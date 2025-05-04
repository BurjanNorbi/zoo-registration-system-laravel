@extends('layouts.layout')

@section('title', 'Archivált állatok')

@section('content')
    <h1 class="ps-3">Archivált állatok</h1>
    <hr />
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th style="width: 30%">Állat neve</th>
                    <th style="width: 30%">Faj</th>
                    <th style="width: 30%">Archiválás időpontja</th>
                    <th style="width: 10%">Visszaállítás</th>
                </tr>
            </thead>
            <tbody class="text-center">

                @foreach ($animals as $animal)
                    <tr>
                        <td>{{ $animal->name }}</td>
                        <td>{{ $animal->species }}</td>
                        <td>{{ $animal->deleted_at->format("Y-m-d") }}</td>
                        <td>
                            <a href="{{ route('animals.edit', ['animal' => $animal->id]) }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-angles-right fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- {{ $enclosures->links() }} --}}
    </div>
@endsection
