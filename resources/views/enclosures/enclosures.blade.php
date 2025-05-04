@php
    $isAdmin = Auth::user()->admin;
@endphp

@extends('layouts.layout')

@section('title', 'Kifutók')

@section('content')
    <h1 class="ps-3">Kifutók</h1>
    <hr />
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="text-center table-light">
                <tr>
                    @if($isAdmin)
                        <th style="width: 50%">Kifutó neve</th>
                        <th style="width: 10%">Állatok maximális száma</th>
                        <th style="width: 10%">Állatok száma</th>
                        <th style="width: 10%">Megjelenítés</th>
                        <th style="width: 10%">Szerkesztés</th>
                        <th style="width: 10%">Törlés</th>
                    @else
                        <th style="width: 50%">Kifutó neve</th>
                        <th style="width: 13.3%">Állatok maximális száma</th>
                        <th style="width: 13.3%">Állatok száma</th>
                        <th style="width: 13.3%">Megjelenítés</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-center">

                @foreach ($enclosures as $enclosure)
                    {{-- @dd($enclosure) --}}
                    <tr>
                        <td>{{ $enclosure->name }}</td>
                        <td>{{ $enclosure->limit }}</td>
                        <td>{{ $enclosure->animals()->count() }}</td>
                        <td>
                            <a href="{{ route('enclosures.show', ['enclosure' => $enclosure->id]) }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-angles-right fa-fw"></i>
                            </a>
                        </td>
                        @if($isAdmin)
                            <td>
                                <a href="{{ route('enclosures.edit', ['enclosure' => $enclosure->id]) }}" class="btn btn-primary mx-1"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Szerkesztés">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('enclosures.destroy', ["enclosure" => $enclosure->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="btn btn-danger mx-1"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="Törlés"
                                        {{$enclosure->animals->count() == 0 ? '' : 'disabled' }}
                                    >
                                        <i class="fa-solid fa-trash fa-fw"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $enclosures->links() }}
    </div>
@endsection
