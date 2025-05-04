@php
    $isAdmin = Auth::user()->admin;

    $arePredators = $enclosure->arePredators();
@endphp

@extends('layouts.layout')

@section('title', $enclosure->name)

@section('content')
    <div class="ps-3 me-auto fs-6">
        <h1 class="">{{ $enclosure->name }}
            @if ($arePredators)
                <span class="badge rounded-pill bg-danger text-white ">Ragadozók</span>
            @endif
        </h1>
        <p>Állatok maximális száma: {{ $enclosure->limit }}</p>
        <p>Állatok száma: {{ $enclosure->animals()->count() }}</p>
        <p>Etetés időpontja: {{ $enclosure->feeding_at->format('H:i') }}</p>
    </div>
    <hr />
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($enclosure->animals()->orderBy('species')->orderBy('born_at')->get() as $animal)
            <div class="col">
                <div class="card h-100">
                    <div class="card-header d-flex">
                        <div class="me-auto">
                            <span class="badge bg-secondary">
                                #{{ $loop->index }}
                            </span> |
                            <strong>{{ $animal->name }}</strong> |
                            {{ $animal->species }} |
                            {{ $animal->born_at->format('Y-m-d') }}

                            @if($isAdmin)
                                |
                                <a href="{{ route('animals.edit', ['animal' => $animal->id]) }}" class="btn btn-primary mx-1"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Szerkesztés">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                </a>
                                <form action="{{ route('animals.destroy', ["animal" => $animal->id]) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Törlés">
                                        <i class="fa-solid fa-trash fa-fw"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        @if ($animal->imagename)
                            <div>
                                <a download="{{ $animal->imagename }}" href="{{ Storage::url($animal->imagename_hash) }}">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ Storage::url($animal->imagename ? $animal->imagename_hash : 'placeholder.png') }}"
                            alt=""
                            class="img-fluid w-75">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
