@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col"><h1>Lista rejonów</h1></div>
        <div class="col"></div>

        <div class="col">

            <form method="POST" action="{{ route('rejon.create')}}">
                @csrf

                <h4>Dodaj rejon</h4><br>
                <label>Nazwa</label><br>
                <input type="text" name="nazwa" class="form-control" required><br>

                <input type="submit" value="Dodaj" class="btn btn-success" style="background: green;"><br>
            </form>
        </div>


    </div>

</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Nazwa Rejonu</th>
            <th scope="col">Działania</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rejony as $rejon)
            <tr>
                <td scope="row">{{ $rejon->nazwa }}</td>
                <td scope="row">
                    <a href="{{ url('/rejon/'.$rejon->id.'/edit')}}">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edytuj
                        </button>

                    </a>

                    <form method="POST" action="{{ route('rejon.destroy',$rejon->id)}}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i>Usuń</button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
