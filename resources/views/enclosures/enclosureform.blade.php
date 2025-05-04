@extends('layouts.layout')

@section('title', $enclosure->name ?? 'Új kifutó')

@section('content')
            <h1 class="ps-3">
                @isset($enclosure)
                    {{ $enclosure->name }} szerkesztése
                @else
                    Új kifutó
                @endisset
            </h1>
            <hr />
            <form
                enctype="multipart/form-data"
                method="POST"
                action="{{ isset($enclosure) ? route('enclosures.update', ['enclosure' => $enclosure->id]) : route('enclosures.store') }}">
                @csrf
                @isset($enclosure)
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
                            value="{{ old('name', isset($enclosure) ? $enclosure->name : '') }}"
                        />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- limit --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label" for="limit">Állatok maximális száma: </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control @error('limit') is-invalid @enderror"
                            placeholder="Állatok maximális száma"
                            name="limit"
                            id="limit"
                            value="{{ old('limit', isset($enclosure) ? $enclosure->limit : '') }}"
                        />
                        @error('limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- feeding_at --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label" for="limit">Etetés időpontja: </label>
                    <div class="col-sm-10">
                        <input
                            type="time"
                            class="form-control @error('feeding_at') is-invalid @enderror"
                            name="feeding_at"
                            id="feeding_at"
                            value="{{ old('feeding_at', isset($enclosure) ? $enclosure->feeding_at->format('H:i') : '') }}"
                        />
                        @error('feeding_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @isset($enclosure)
                @isset($users)
                    <div class="mb-3">
                        <table class="table align-middle table-hover">
                            <thead class="text-center table-light">
                                <tr>
                                    <th style="width: 50%">Gondozó neve</th>
                                    <th style="width: 50%">Be van osztva</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @error('caregivers.*')
                                    <tr>
                                        <td colspan="2">
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        </td>
                                    </tr>
                                @enderror
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <label for="{{ $user->id }}">{{ $user->name }}</label>
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                class="@error('caregivers') is-invalid @enderror"
                                                name="caregivers[]"
                                                id="{{ $user->id }}"
                                                value="{{ $user->id }}"
                                                {{ in_array($user->id, old('caregivers', $enclosure->users->pluck('id')->toArray())) ? 'checked' : '' }}
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endisset
                @endisset
                <div class="row">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </div>
            </form>
    </body>
</html>

@endsection
