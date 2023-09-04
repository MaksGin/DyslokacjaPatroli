@extends('layouts.app')


@section('content')


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="card">
    <div class="card-header">Sklad Wydziału: {{ $wydzial->nazwa }}
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('wydzial.index') }}"> Powrót</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imie i Nazwisko</th>
                    <th>Rola</th>
                </tr>
            </thead>
            <tbody>
            <!-- sprawdzenie czy wydzial_id uzytkownika jest rowny id wybranego dzialu -->

            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            {{ $role->name }}
                        @endforeach
                    </td>
                </tr>
            @endforeach







            </tbody>
        </table>
    </div>
</div>
<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
@endsection
