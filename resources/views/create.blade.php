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

<!DOCTYPE html>
<html>
<head>
    <link rel = "stylesheet" href= "{{ URL::asset('css/select2.css')}}">
</head>

<body>
<div class="card">
  <div class="card-header"><b>Dodaj Patrol</b></div>

  <div class="card-body">

    <form action="{{ url('/patrol') }}" method="POST">
        @csrf

        <input type="hidden" name="kom" id="kom" class="form-control" required><br>

        <label>Data</label><br>
            <input type="date" name="data" value="{{ $selectedDate }}" id="data" class="form-control" required><br>

        <label>Godzina Rozpoczęcia</label><br>
            <input type="text" name="g_rozp" id="g_rozp" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" required><br>

        <label>Godzina Zakończenia</label><br>
            <input type="text" name="g_zak" id="g_zak" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" required><br>

        <div class="form-group">
            <label for="wydzial_id">Wybierz wydział:</label>
                <select name="wydzial_id" class="form-control">
                    @foreach ($wydzialy as $wydzial)
                        @php
                            $selected = $wydzial->id == $id ? 'selected' : '';
                        @endphp
                        <option value="{{ $wydzial->id }}" {{ $selected }}>{{ $wydzial->nazwa }}</option>
                    @endforeach
                </select>
        </div>



        <label>Uwagi</label><br>
            <input type="text" name="uwagi" id="uwagi" class="form-control" required><br>

        <label>Rejon</label><br>
            <select input="text" name="rejon" id="rejon" class="form-control rejon" required></select><br>

        <label style="margin-top: 20px">Kryptonim</label><br>
            <select input="text" name="krypt" id="krypt" class="form-control krypt" required></select>


        <center><input type="submit" value="Zapisz" class="btn btn-success" style="background: green; margin-top:20px;"><br></center>
    </form>
  </div>
</div>


<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>

</body>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>

<!-- skrypt obsługujący wyświetlanie listy podpowiedzi kryptonimów i rejonów
    umożliwia dodawanie nowego rekordu do bazy danych -->
<script type="text/javascript">
    $('.krypt').select2({

        placeholder: 'Wpisz kryptonim',
        tags:true,
        allowClear: false,

        ajax: {
        url: '/autocomplete1',
        dataType: 'json',

        processResults: function (data) {
          return {
            results: data.map(function (item) {
              return {
                text: item.value,
                id: item.value
              };
            })
          };
        },


      }

    });

    $('.rejon').select2({

        placeholder: 'Wpisz rejon',
        tags: true,
        allowClear: false,

        ajax:{
            url:'/autocompleteRejon',
            dataType: 'json',

            processResults: function(data){
                return{
                    results: data.map(function (item){
                        return{
                            text: item.value,
                            id: item.value
                        };
                    })
                };
            }
        }
    });
</script>
@endsection


