@extends('layouts.app')


@section('content')
<form action="{{ url('/savekryptonim') }}" method="POST">
    @csrf

    <label for="osoba">Wybierz osobę:</label>
    <select name="osoba" id="osoba">
        @foreach($sklads as $sklad)
            <option value="{{ $sklad->id }}">
                {{ $sklad->imie }} {{ $sklad->nazwisko }} (ID: {{ $sklad->id }}, ID_patrolu: {{ $sklad->id_patrolu }})
            </option>
        @endforeach
        <!-- Dodaj pozostałe osoby z tabeli sklads jako opcje -->
    </select>
    <br>

    <label for="kryptonim">Nazwa kryptonimu:</label>
    <input type="text" name="kryptonim" id="kryptonim" required>
    <br>

    <input type="submit" value="Zapisz" class="btn btn-success" style="background: green;"><br>
</form>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Nazwa kryptonimu</th>
            <th scope="col">Przypisana osoba</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kryptSklads as $kryptSklad)
            <tr>
                <td scope="row">{{ $kryptSklad->kryptonim->nazwa }}</td>
                <td scope="row">
                    @if($kryptSklad->sklad)
                        {{ $kryptSklad->sklad->imie }} {{ $kryptSklad->sklad->nazwisko }}
                    @else
                        Brak przypisanej osoby
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



@endsection
