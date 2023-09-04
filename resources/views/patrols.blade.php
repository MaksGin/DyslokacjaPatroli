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


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (isset($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
@endif


@php
    $polskieMiesiace = array(
        1 => 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca',
        'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'
    );
    $selectedDateObj = new DateTime($selectedDate);
    $dzien = $selectedDateObj->format('j');
    $miesiac = $selectedDateObj->format('n');
    $rok = $selectedDateObj->format('Y');
    $polskaData = $dzien . ' ' . $polskieMiesiace[$miesiac] . ' ' . $rok;
@endphp






<div class="row">
  <div class="col-sm-2"><form action="{{ route('patrols.getByDate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="selected_date">Wybierz datę:</label>
            <input type="date" class="form-control" id="selected_date" name="selected_date" required>
        </div>
        <center>
            <button type="submit" class="btn btn-primary">Zmień datę</button>
        </center>
    </form>
</div>
    <div class="col-sm-10">
    </div>
</div>


<div class="col text-right">
    <center><h1 style="font-style: bold; font-size: 30px;">Patrole na dzień {{ $polskaData }}</h1></center>

    <!-- przycisk Pobierz PDF -->
    <a href="{{ route('patrols.export.pdf', ['selectedDate' => $selectedDate])  }}"><button class="btn btn-primary btn-sm">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Pobierz PDF
    </button></a>
</div>

@foreach($wydzialy as $wydzial)
    <div class="container bdr" style="margin-top: 50px;" >
        <div class="row justify-content-end">
            <div class="col"></div>
            <div class="col">
            <center><h1 style="font-style: bold; font-size: 20px;">{{ $wydzial->nazwa }}</h1></center>
            </div>
            <div class="col text-right">

            </div>
        </div>
        <!-- unikalny identyfikator dla każdej z tabel -->
        <table class="table rounded-3" id="patrol-table-{{$wydzial->id}}" style="margin-top: 50px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="cursor: pointer;">
                        <span onclick="sortujPogodzinie('patrol-table-{{$wydzial->id}}')">
                            Godzina Rozpoczęcia
                        </span>

                    </th>
                    <th scope="col">Godzina Zakończenia</th>
                    <th scope="col">Uwagi</th>
                    <th scope="col" style="cursor: pointer;">
                        <span onclick="sortujPatrole('patrol-table-{{$wydzial->id}}')">
                            Rejon
                        </span>

                    </th>
                    <th scope="col">Kryptonim</th>
                    <th scope="col" colspan="3"><center>Działania</center></th>
                    <th>
                        <a href="{{ route('patrol.create1', ['selectedDate' => $selectedDate, 'id' => $wydzial->id]) }}">
                            <button class="btn btn-primary btn-sm"  style="float: right; width: 150px;">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Dodaj Patrol
                            </button>
                        </a>

                        <a href="{{ route('import.excel', ['selectedDate' => $selectedDate, 'id' => $wydzial->id])}}">

                        <button class="btn btn-primary btn-sm" style="float: right;width: 150px;">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Importuj CSV
                        </button>
                    </a></th>

                </tr>
            </thead>
            <tbody>
            @php
                $hasPatrols = false;
            @endphp
                @foreach($patrols as $patrol)
                    @php
                        $currentUser = auth()->user();
                        $isSameWydzial = $patrol->wydzialy->contains('id', $wydzial->id);
                    @endphp
                    <!-- czy dany patrol jest przypisany do wydzialu -->
                    @if(auth()->check() && $isSameWydzial)
                     @php
                        $hasPatrols = true;
                    @endphp

                        <tr onclick="window.location='{{ route('patrol.sklad', $patrol['id']) }}'">

                            <td>{{ $patrol['g_rozp'] }}</td>
                            <td>{{ $patrol['g_zak'] }}</td>
                            <td>{{ $patrol['uwagi'] }}</td>
                            <td>{{ $patrol['rejon'] }}</td>
                            <td>{{ $patrol['krypt'] }}</td>
                            <td>
                                @can('patrol-edit')
                                <a href="{{ url('/patrol/' . $patrol->id . '/edit') }}" title="Edit Patrol">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edytuj
                                    </button>
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('patrol-delete')
                                <form method="POST" action="{{ route('patrol.destroy', $patrol->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Patrol" style="background: red;"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</button>
                                </form>
                            </td>
                            @endcan
                            <td><a class="btn btn-primary btn-sm show-sklad-btn" data-patrol-id="{{ $patrol['id'] }}">
                                Wiecej
                            </a></td>
                            <td></td>
                        </tr>


                        <!-- ukryty wiersz, pojawia się po kliknieciu przycisku Więcej -->
                        <tr class="patrol-details-row" id="patrol-details-row-{{ $patrol['id'] }}" style="display: none;">
                            <td colspan="9">

                                @if(count($patrolSklady[$patrol->id]) === 0)

                                   <b>Skład patrolu pusty</b>

                                @else

                                <b>Skład patrolu:</b><br>
                                    <ol>
                                        @foreach($patrolSklady[$patrol->id] as $osoba)
                                            <li>{{ $osoba->imie }}

                                                <a href="{{ url('/sklad/' . $osoba->id . '/edit') }}" title="Edit sklad">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edytuj
                                                        </button>
                                                </a>

                                                <form method="POST" action="{{ route('sklad.destroy1', [$osoba->id, 'selectedDate' => $selectedDate]) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm"  style="background: red;"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</button>
                                                </form>

                                            </li>
                                        @endforeach
                                    </ol>
                                @endif

                            </td>
                        </tr>
                    @endif
                @endforeach
                @if(!$hasPatrols)
                    <tr>
                        <td colspan="10"><center>Brak patroli dla tego wydziału.</center></td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
@endforeach


</body>

<script src="{{ asset('js/jquery3.min.js') }}"></script>

<!-- obsługa wiersza składu patrolu -->
<script>
    $(document).ready(function () {
        $(".clickable-row").click(function () {
            const patrolId = $(this).data("patrol-id");
            const detailsRow = $("#patrol-details-row-" + patrolId);


            if (!detailsRow.is(":visible")) {
                $.ajax({
                    type: "GET",
                    url: "/patrol/" + patrolId + "/sklad", //żadanie ajax na adres url
                    success: function (data) {

                        detailsRow.find("td").html(data);
                        detailsRow.fadeIn(); // animacja pojawiania sie wiersza
                    },
                    error: function () {
                        alert("Wystąpił problem podczas pobierania danych o składzie patrolu.");
                    }
                });
            } else {
                detailsRow.fadeOut(); //animacja znikania wiersza
            }
        });

        $(".show-sklad-btn").click(function (event) {
            event.stopPropagation();
            const patrolId = $(this).data("patrol-id");
            const detailsRow = $("#patrol-details-row-" + patrolId);
            detailsRow.fadeToggle(); // wysuwanie / chowanie wiersza
        });
    });
</script>


<p class="text-center text-primary"><small>Maksymilian Gintner</small></p>

</html>
@endsection
