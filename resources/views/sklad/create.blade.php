@extends('layouts.app')


@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<?php



?>

<div class="card">
  <div class="card-header">Dodaj osobę do patrolu</div>
  <div class="card-body">
    <form action="{{ route('sklad.store') }}" method="POST">
    @csrf

    <input type="hidden" name="patrol_id" value="{{ $patrol ? $patrol->id : '' }}">

    <label for="imie">Imię:</label>
    <input type="text" name="imie" id="imie" required>

    <label for="nazwisko">Nazwisko:</label>
    <input type="text" name="nazwisko" id="nazwisko" required>

    <input type="submit" value="Zapisz" class="btn btn-success" style="background: green;"><br>
    </form>
  </div>
</div>
<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
@endsection
