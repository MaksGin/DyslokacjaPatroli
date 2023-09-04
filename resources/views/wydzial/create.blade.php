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

<div class="row">
    <div class="col-lg-12 margin-tb">

    </div>
</div>
<div class="card">
  <div class="card-header">Dodaj Wydział</div>
  <div class="card-body">
    <form action="{{ route('wydzial.store') }}" method="POST">
    @csrf

    <label>Nazwa Wydziału</label><br>
      <input type="text" name="nazwa" id="nazwa" class="form-control" required><br>
    <a class="btn btn-primary" href="{{ route('wydzial.index') }}">Powrót</a>
    <input type="submit" value="Zapisz" class="btn btn-success" style="background: green;"><br>
    </form>
  </div>
</div>

<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
</body>
</html>
@endsection
