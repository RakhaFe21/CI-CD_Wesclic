@extends('install.app')
@section('content')
<div class="text-center">
    <h1 class="font-weight-bold">Instalasi Sistem BLK Wonosobo</h1>
    <h5>Tidak perlu khawatir, proses ini hanya berlangsung diawal implementasi sistem saja</h5>

</div>
<div class="m-5">
    <ul class="list-group">
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa  fa-check"></i> Database Host Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database User Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database Password</h6>
        </li>
    </ul>
</div>

<div class="m-2">
    <p>Selama proses instalasi, kami akan mengecek apakah<strong> (.env file) </strong> memiliki <strong>akses ke server</strong>. Kami juga mengecek apakah
        <strong>plugin curl</strong> tersedia di server anda atau tidak. Proses ini aman, tidak akan mengambil data-data anda</p>
    <br>
    <p>Klik tombol dibawah jika sudah siap untuk instalasi. Proses ini sebaiknya dilakukan melalui seseorang yang paham tentang sistem ini</p>
    <h6>Wesclic Studiow</h6>

    <div class="center">
        <a href="{{route('permission')}}" class="btn btn-block btn-primary"> Mulai Proses Instalasi</a>
    </div>
</div>



@endsection
