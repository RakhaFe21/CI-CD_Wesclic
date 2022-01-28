@extends('layouts.master')
@section('title','Student')
@section('parentPageTitle', 'All Student')
@section('content')
<div class="card mx-2 mb-3">
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="float-left">
                <h3>@translate(List Siswa)</h3>
            </div>
            <div class="float-right">
                <div class="row">
                    <div class="col">
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                    placeholder="@translate(nama/Username)" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Cari)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th> </th>
                        <th>@translate(Gambar)</th>
                        <th>@translate(User Name)</th>
                        <th>@translate(NIK)</th>
                        <th>@translate(Logbook)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $item)
                    <tr>
                        <td><input type="checkbox" name="course_id[]" value="{{ $item->id }}" class="form-check-input"
                                id="exampleCheck-{{ $item->id }}"></td>
                        <td>
                            @if($item->image != null)
                            <img src="{{filePath($item->image)}}" class="img-thumbnail rounded-circle avatar-lg"><br />
                            @else
                            <img src="" class="img-thumbnail rounded-circle avatar-lg" alt="avatar"><br />
                            @endif
                        </td>
                        <td>{{$item->name}}</td>
                        <td>
                            {{$item->nik ?? 'N/A'}}
                        </td>
                        <td>
                            <a class="btn btn-primary" href="javascript:;"
                                onclick="forModal('{{ route('student.enroll.courses.modal', $item->user_id) }}', '@translate(Pelatihan yang diikuti)')">
                                @translate(Lihat)</a>
                        </td>
                    </tr>
                    @empty
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td>
                            <h3 class="text-center">No Data Found</h3>
                        </td>
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
    </form>
</div>

@endsection