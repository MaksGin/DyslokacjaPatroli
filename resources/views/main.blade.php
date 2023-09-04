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
<div class="container">


</div>
<div class="row">
  <div class="col-4"></div>
  <div class="col-4">
    <form action="{{ route('patrols.getByDate') }}" method="POST">
        @csrf
        <div class="form-group" style="margin-top:30px;">
            <label for="selected_date">Wybierz datę:</label>
            <input type="date" class="form-control" id="selected_date" name="selected_date" required>
        </div>
        <center>
            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Pobierz patrole</button>
        </center>
    </form>
    <!--
    <a href="{{ url('/patrol/create') }}" class="btn btn-success btn-sm" title="Add New Patrol">
        <i class="fa fa-plus" aria-hidden="true"></i> Add New
    </a>-->

  
    
    </div>
    
  <div class="col-4"></div>
</div>
<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
</body>
</html>
@endsection