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

<div class="card">
  <div class="card-header">Edytuj osobę patrolu</div>
  <div class="card-body">
    <form action="{{ route('sklad.update',$sklad->id) }}" method="POST">
        {!! csrf_field() !!}
        @method('PATCH')
        <input type="hidden" name="patrol_id" value="{{ $sklad->id_patrolu }}">

        <label for="imie">Imię:</label>
        <input type="text" name="imie" id="imie" value="{{ $sklad->imie }}" required>

        <label for="nazwisko">Nazwisko:</label>
        <input type="text" name="nazwisko" id="nazwisko" value="{{ $sklad->nazwisko }}" required>  
        
        <input type="submit" value="Save" class="btn btn-success" style="background: green;"><br>
    </form>

  </div>
</div>
<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>


@endsection