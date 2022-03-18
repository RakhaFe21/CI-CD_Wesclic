@extends('install.app')
@section('content')
@if($message = Session::get('success'))

  <div class="card-body">
      <h3 class="text-lg-center p-3">
          @translate(Import Sql Database)</h3>
      <p>
          @translate(Dengan mengklik import, anda akan menginstal database beserta isi demo dari databasenya)</p>
      <a href="{{route('org.create')}}" class="btn btn-block btn-success">
          @translate(Import Sql)</a>
  </div>

    <hr>


@endif

@if($message = Session::get('wrong'))

  <div class="card-body">
      <p>
          @translate(Cek koneksi database)</p>
      <a href="{{route('create')}}" class="btn btn-block btn-danger">
          @translate(Kembali ke database setup)</a>
  </div>

@endif
@endsection
