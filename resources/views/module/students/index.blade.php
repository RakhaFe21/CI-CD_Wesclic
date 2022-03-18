@extends('layouts.master')
@section('title','Peserta Pelatihan')
@section('parentPageTitle', 'All Student')
@section('content')
    <div class="card mx-2 mb-3">
        <div class="card-header">
            <div class="float-left">
                <h3>@translate(Data Peserta)</h3>
            </div>
            <div class="float-right">
                <div class="row">
                    <div class="col">
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Nama/Username)"
                                       value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Cari)</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (auth()->user()->user_type != 'Executive') 
                        <div class="col">
                            <a href="#!"
                            onclick="forModal('{{ route("student.create.modal") }}', '@translate(Tambah Siswa)')"
                            class="btn btn-primary">
                            <i class="la la-plus"></i>
                            @translate(Tambah Siswa Baru)
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>@translate(Gambar)</th>
                    <th>@translate(Nama)</th>
                    <th>@translate(NIK)</th>
                    <th>@translate(Pelatihan)</th>
                    @if (auth()->user()->user_type != 'Executive') 
                    <th>@translate(Ubah Password)</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse($students as  $item)
                    <tr>
                        <td>{{ ($loop->index+1) + ($students->currentPage() - 1)*$students->perPage() }}</td>
                        <td>
                            @if($item->image != null)
                                <img src="{{filePath($item->image)}}" class="img-thumbnail rounded-circle avatar-lg"><br />
                            @else
                                <img src="" class="img-thumbnail rounded-circle avatar-lg" alt="avatar"><br />
                            @endif
                        </td>
                        <td>{{$item->name}}</td>
                        <td>
                            {{$item->user && $item->user->nik ? $item->user->nik : 'N/A'}}
                        </td>
                        <td>
                            <a class="btn btn-primary" 
                                href="javascript:;"
                                onclick="forModal('{{ route('student.enroll.courses.modal', $item->user_id) }}', '@translate(Pelatihan yang diikuti)')">
                            @translate(Lihat)</a>
                        </td>
                        @if (auth()->user()->user_type != 'Executive') 
                        <td>
                            <a class="btn btn-primary" 
                                href="{{ route('student.ganti_password', $item->user_id) }}">
                            @translate(Ubah Password)</a>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td><h3 class="text-center">Tidak Ada Data Ditemukan</h3></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                @endforelse
                </tbody>
                <div class="float-left">
                    {{ $students->links() }}
                </div>
            </table>
        </div>
    </div>

@endsection
