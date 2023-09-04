@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>
<head>


</head>
<body>
<h2>Przegląd patroli</h2>
<form method="GET" action="{{ route('allPatrols.index') }}">
  <label for="days">Wpisz liczbe dni do przodu:</label>
  <input type="number" name="days" id="days" min="1" max="30" required>
  <button class="btn btn-primary btn-sm" type="submit">pokaż</button>
</form>

<table class="table" style="margin-top: 50px;">
        <thead class="thead-dark">
  <tbody>
    @php
        $startDate = null; // aktualna data
    @endphp

    @foreach($patrols as $patrol)
      @if ($patrol->data !== $startDate)
        @php
        $startDate = $patrol->data;
        @endphp
        <tr>
          <th scope="col" >{{ $startDate }}</th>

        </tr>
      @endif
      <tr onclick="window.location='{{ route('patrolAll.sklad', $patrol['id']) }}'"> <!-- przejscie do skladu patrolu -->

        <td>
          @foreach ($patrol->wydzialy as $wydzial) <!-- pobranie nazwy wydziału z tabeli pośredniej -->
            {{ $wydzial->nazwa }}
              @if (!$loop->last)
                              ,
             @endif
          @endforeach</td>
        <td>{{ $patrol->g_rozp }}</td>
        <td>{{ $patrol->g_zak }}</td>
        <td>{{ $patrol->uwagi }}</td>
        <td>{{ $patrol->rejon }}</td>
        <td>{{ $patrol->krypt }}</td>
        <p></p>

      </tr>
    @endforeach
  </tbody>

</table>
</html>
@endsection
