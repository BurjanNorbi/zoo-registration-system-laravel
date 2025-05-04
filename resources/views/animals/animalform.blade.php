@extends('layouts.layout')

@section('title', $animal->name ?? 'Új állat')

@section('content')
            <h1 class="ps-3">
                @isset($animal)
                    {{ $animal->name }} szerkesztése
                @else
                    Új állat
                @endisset
            </h1>
            <hr />
            <form
                enctype="multipart/form-data"
                method="POST"
                action="{{ isset($animal) ? route('animals.update', ['animal' => $animal->id]) : route('animals.store') }}">
                @csrf
                @isset($animal)
                    @method('PUT')
                @endisset
                {{-- name --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"for="name">Név: </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Név"
                            name="name"
                            id="name"
                            value="{{ old('name', isset($animal) ? $animal->name : '') }}"
                        />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- species --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"for="species">Faj: </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control @error('species') is-invalid @enderror"
                            placeholder="Faj"
                            name="species"
                            id="species"
                            value="{{ old('species', isset($animal) ? $animal->species : '') }}"
                        />
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- is_predator --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Ragadozó</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input @error('is_predator') is-invalid @enderror"
                                type="radio"
                                name="is_predator"
                                id="predator_yes"
                                value="1"
                                {{ old('is_predator', isset($animal) ? $animal->is_predator : null) == 1 ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="predator_yes">Igen</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input @error('is_predator') is-invalid @enderror"
                                type="radio"
                                name="is_predator"
                                id="predator_no"
                                value="0"
                                {{ old('is_predator', isset($animal) ? $animal->is_predator : null) == 0 ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="predator_no">Nem</label>
                        </div>

                        @error('is_predator')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- born_at --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label" for="born_at">Születési dátum: </label>
                    <div class="col-sm-10">
                        <input
                            type="date"
                            class="form-control @error('born_at') is-invalid @enderror"
                            name="born_at"
                            id="born_at"
                            value="{{ old('born_at', isset($animal) ? $animal->born_at->format('Y-m-d') : '') }}"
                        />
                        @error('born_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- enclosure_id --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label" for="born_at">Kifutó: </label>
                    <div class="col-sm-10">
                        <select class="form-select @error('enclosure_id') is-invalid @enderror" name="enclosure_id" id="enclosure_id">
                            <option value="x" disabled selected>Kifutó</option>
                            @foreach ($enclosures as $enclosure)
                                <option
                                    value={{ $enclosure->id }}
                                    @selected(
                                        old('enclosure_id',
                                        isset($animal) ? $animal->enclosure_id : '') == $enclosure->id)
                                >
                                    {{ $enclosure->name }} | {{ $enclosure->animals->count() }}/{{ $enclosure->limit }}{{ $enclosure->arePredators() ? ' | Ragadozók' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('enclosure_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- image --}}
                <div class="mb-3 d-flex">
                    <label class="col-sm-2 col-form-label" for="image">Kép: </label>
                    <input
                        type="file"
                        class="form-control @error('image') is-invalid @enderror"
                        id="file"
                        name="image"
                    >
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </div>
            </form>
    </body>
</html>

@endsection
