@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>
<head>

</head>
<body>

<div class="container mt-5">




  <div class="card">

    <div class="card-header font-weight-bold">
      <h2 class="float-left">Importuj plik CSV</h2>

    </div>

    <div class="card-body">

        <form id="excel-csv-import-form" method="POST"  action="{{ url('import-excel-csv-file/' . $selectedDate.'/'.$id) }}" accept-charset="utf-8" enctype="multipart/form-data">

          @csrf

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" name="file" placeholder="Choose file">
                    </div>
                    @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="submit">OK</button>
                </div>
            </div>
        </form>

    </div>

  </div>

</div>
</body>
</html>
@endsection
