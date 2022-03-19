
@extends('install.app')
@section('content')
    <div class="pad-btm text-center">
        <h1 class="h3">Selamat!!!</h1>
        <p>Kamu telah menyelesaikan proses installasi. Silahkan lanjutkan untuk memulai menggunakan web ini.</p>
    </div>
    <div class="m-2"></div>
    <div class="text-center">
        <a href="{{ \Illuminate\Support\Str::before(env('APP_URL'),'/public') }}" class="btn btn-primary">Mulai Sekarang</a>
    </div>
@endsection
