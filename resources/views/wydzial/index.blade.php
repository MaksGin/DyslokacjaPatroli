@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edycja Wydziałów</h2>
        </div>
        
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="container" style="margin-top: 50px;">
    <div class="row justify-content-end"> <!-- Dodano klasę justify-content-end -->
        <div class="col"></div>
        <div class="col"></div>
        <div class="col text-right">
           
        <!-- button dodawania wydziału --> 
        @can('wydzial-add')
            <a href="{{ route('wydzial.create') }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Dodaj Wydział
                </button>
            </a>
        @endcan
        </div>
    </div>
</div>

<table class="table" style="margin-top: 50px;">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nazwa</th>
                <th scope="col" colspan="2">Działania</th>
            </tr>
        </thead>
        <tbody>
        @foreach($wydzialy as $wydzial)
        @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Koordynator')
        || (Auth::user()->hasRole('KoordynatorWPI') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorRD') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorRD') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorWK') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorWP') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorKPP') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorWiazownica') && $wydzial->users->contains(Auth::user()))
        || (Auth::user()->hasRole('KoordynatorRadymno') && $wydzial->users->contains(Auth::user())) 
        || (Auth::user()->hasRole('KoordynatorPruchnik') && $wydzial->users->contains(Auth::user())) 
        || (Auth::user()->hasRole('KoordynatorPG') && $wydzial->users->contains(Auth::user())))    
                <tr onclick="window.location='{{ route('wydzial.sklad', $wydzial['id']) }}'">
                    <td>{{ $wydzial->id }}</td>
                    <td>{{ $wydzial->nazwa }}</td>
                    <td>
                        <a href="{{ url('/wydzial/' . $wydzial->id . '/edit') }}" title="Edit Wydzial">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edytuj
                            </button>
                        </a>
                    </td>
                    <td>
                    @can('wydzial-delete') 
                        <form method="POST" action="{{ route('wydzial.destroy', $wydzial->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Wydzial" style="background: red;" onclick="return confirm('Confirm delete?')">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Usuń
                            </button>
                        </form>
                    @endcan
                    </td>
                </tr>
            @endif
        @endforeach


        </tbody>
    </table>






<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
@endsection

