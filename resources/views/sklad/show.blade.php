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

@php
    $Allpatrols = Route::currentRouteName() === 'patrolAll.sklad';
    // Ustawienie na true, jeśli jesteśmy na stronie 'allPatrols'
@endphp

<div class="card">
    <div class="card-header">Skład Patrolu w rejonie {{ $patrol->rejon }} na dzień {{$patrol->data}}</div>
    <div class="col text-right" style="margin-top: 20px;">
    <!-- przycisk cofania do patrols -->
    @if($Allpatrols)
        <div class="col text-right" style="margin-top: 20px;">

            <!-- Przycisk cofania do strony allpatrols dla komendanta -->
            <a class="btn btn-primary btn-sm" href="{{ route('allPatrols.index') }}">Cofnij</a>

            @auth
            @can('sklad-create')
                <a href="{{ route('sklad.create', ['patrol_id' => $patrol->id]) }}">
                    <button class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Dodaj osobę
                    </button>
                </a>
            @endcan
            @endauth
        </div>
    @else
        <div class="col text-right" style="margin-top: 20px;">

            <!-- przycisk cofania do strony patroli dla konkretnej daty -->
            <a class="btn btn-primary btn-sm" href="{{ route('patrols.getByDate', ['selected_date' => $selected_date]) }}">Cofnij</a>

            @auth
                @can('sklad-create')
                    <a href="{{ route('sklad.create', ['patrol_id' => $patrol->id]) }}">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Dodaj osobę
                        </button>
                    </a>
                @endcan
            @endauth
        </div>
    @endif

    <div class="card-body">

        <h4 style="float: left;">Skład:</h4>
        <table class="table .table-striped rounded-3" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th scope="col">Imie</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col" colspan="2">Działania</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sklad as $osoba)
                    <tr>
                        <td>{{ $osoba->imie }} </td>
                        <td>{{ $osoba->nazwisko }}</td>

                        @can('sklad-edit')
                        <td>
                            <a href="{{ url('/sklad/' . $osoba->id . '/edit') }}" title="Edit sklad">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edytuj
                                </button>
                            </a>
                        </td>
                        @endcan
                        @can('sklad-delete')
                        <td>
                            <form method="POST" action="{{ route('sklad.destroy', $osoba->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm"  style="background: red;"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>

</body>
</html>
@endsection
