@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Zarządzanie Rolami</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('roles.create') }}">Stwórz Role</a>
        @endcan

        @can('permission-create')
            <a class="btn btn-success" href="{{ route('permissions.create') }}">Stwórz permisje</a>
        @endcan
        
        @can('permission-delete')
            <a class="btn btn-success" href="{{ route('permissions.show2') }}">Usuń permisje</a>
        @endcan



        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif


<table class="table table-bordered">
  <tr>
     <th>Id</th>
     <th>Nazwa</th>
     <th width="280px">Działania</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Więcej</a>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edytuj</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Usuń', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>


{!! $roles->render() !!}


<div class="fixed-bottom bg-light text-center">
    <p class="text-center text-primary"><small>Maksymilian Gintner</small></p>
</div>
@endsection