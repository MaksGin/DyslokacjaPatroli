@extends('layouts.app')


@section('content')

<h1>Edytuj Rejon</h1>

<form action="{{ route('rejon.update', $rejonToEdit->id) }}" method="POST">
    {!! csrf_field() !!}
    @method('PATCH')
    <input type="hidden" name="id" value="{{ $rejonToEdit->id }}" />

    <label>Nazwa</label><br>
    <input type="text" name="nazwa" value="{{ $rejonToEdit->nazwa }}" class="form-control" required><br>

    <a class="btn btn-primary" href="{{ route('rejony.index') }}">Powrót</a>
    <input type="submit" value="Aktualizuj" class="btn btn-success" style="background: green;"><br>
  </form>


@endsection
