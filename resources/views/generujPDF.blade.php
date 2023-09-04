


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
    @page {
        margin:5px;
    }
    body {
        font-family: DejaVu Sans, sans-serif;
        margin: 5px;
     }

    table, td, th {
        border: 1px solid;
        letter-spacing: -1px;


    }
    td{
        padding: 0;
        line-height: 1;
    }
    table {
    width: 100%;
    border-spacing: 0;

    }

    div.footer {
                position: fixed;
                bottom: 20px;
                left: 0;
                right: 0;
                text-align: center;
            }

    .page-break {
    page-break-after: always;
    }

    </style>
</head>
<body>



DYSLOKACJA SŁUŻBY na dzień: {{$selectedDate}}<br>

@foreach($wydzialy as $wydzial)
<table>
        <!-- unikalny identyfikator dla każdej z tabel -->

            <thead class="thead">
                <tr> <th colspan="7" width="100%">{{$wydzial->nazwa}}</th> </tr>
            </thead>
            <thead class="thead">
                <tr>
                    <th width="10%"><p style="font-size:8px">Godzina<br>rozpoczęcia</p></th>
                    <th width="10%"><p style="font-size:8px">Godzina<br> zakończenia</p></th>
                    <th width="25%"><p style="font-size:8px">Skład Patrolu</p></th>
                    <th width="15%"><p style="font-size:8px ">Rejon</p></th>
                    <th width="25%"><p style="font-size:8px">Uwagi</p></th>
                    <th width="15%"><p style="font-size:8px">Kryptonim</p></th>
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

                        <tr>
                            <td>{{ $patrol['g_rozp'] }}</td>
                            <td>{{ $patrol['g_zak'] }}</td>
                            <td>
                                <?php
                                $sklad=App\Models\Patrol::find($patrol['id'])->sklad()->get();
                                ?>

                                @if ($sklad->isEmpty())
                                    <p>Brak składu patrolu.</p>
                                @else

                                        @foreach ($sklad as $osoba)
                                            {{ $osoba->imie }} {{ $osoba->nazwisko }} <br>
                                        @endforeach

                                @endif
                            <td style="text-align: center">{{ $patrol['rejon'] }}</td>
                            <td>{{ $patrol['uwagi'] }}</td>
                            <td style="text-align: center">{{ $patrol['krypt'] }}</td>

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
@endforeach




</body>

</html>
