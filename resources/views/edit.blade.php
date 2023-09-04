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
  <div class="card-header">Edit Patrol</div>
  <div class="card-body">
    <form action="{{ route('patrol.update', $patrol->id) }}" method="POST">
      {!! csrf_field() !!} <!-- ukryte pole z tokenem -->
      @method('PATCH')  <!--dyrektywa BLADE aktualizacja zasobu -->
      <input type="hidden" name="id" value="{{ $patrol->id }}" />


      <input type="hidden" name="kom" value="{{ $patrol->kom }}" class="form-control" required><br>

      <label>Date</label><br>
      <input type="date" name="data" value="{{ $patrol->data }}" class="form-control" required><br>

      <label>Godzina Rozpoczęcia</label><br>
      <input type="text" name="g_rozp" value="{{ $patrol->g_rozp }}" class="form-control" required><br>

      <label>Godzina Zakończenia</label><br>
      <input type="text" name="g_zak" value="{{ $patrol->g_zak }}" class="form-control" required><br>

      <label>Uwagi</label><br>
      <input type="text" name="uwagi" value="{{ $patrol->uwagi }}" class="form-control" required><br>

      <label>Rejon</label><br>
      <input type="text" name="rejon" value="{{ $patrol->rejon }}" class="form-control" required><br>

      <label>Kryptonim</label><br>
      <input type="text" name="krypt" value="{{ $patrol->krypt }}" class="form-control" required><br>

      <input type="submit" value="Aktualizuj" class="btn btn-success" style="background: green;"><br>
    </form>
  </div>
</div>

<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
</body>
</html>
@endsection
