@extends('layouts.master')
@section('title','Student')
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
                                placeholder="@translate(nama/Username)" value="{{Request::get('search')}}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">@translate(Cari)</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col">
                    <a href="#!" onclick="forModal('{{ route(" student.create.modal") }}', '@translate(Tambah Siswa)' )"
                        class="btn btn-primary">
                        <i class="la la-plus"></i>
                        @translate(Tambah Siswa Baru)
                    </a>
                </div>

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
                    <th>@translate(Ubah Password)</th>
                    <th>@translate(Status)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $item)
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
                        {{$item->nik ?? 'N/A'}}
                    </td>
                    <td>
                        <a class="btn btn-primary" href="javascript:;"
                            onclick="forModal('{{ route('student.enroll.courses.modal', $item->user_id) }}', '@translate(Pelatihan yang diikuti)')">
                            @translate(Lihat)</a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('student.ganti_password', $item->user_id) }}">
                            @translate(Ubah Password)</a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">

                                <span class="live-icon">Pendaftaran</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">



                                <div class="userbox">
                                    <ul class="list-unstyled mb-0">


                                        <li class="media dropdown-item">
                                            <a href="" class="profile-icon">
                                                @translate(Pendaftaran)</a>
                                        </li>

                                        <li class="media dropdown-item">
                                            {{-- Todo::raw logout script code--}}
                                            <a href="" class="profile-icon">

                                                @translate(Pelatihan)

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="kanban-menu"> -->
                        <!-- <div class="dropdown">
                                    <button class="btn btn-primary" type="button"
                                            id="KanbanBoardButton1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Pendaftaran</button>
                                    <div class="dropdown-menu dropdown-menu-right action-btn"
                                         aria-labelledby="KanbanBoardButton1" x-placement="bottom-end">
                                        <a class="dropdown-item" href="{{ route('students.show', $item->user_id) }}">
                                            <i class="feather icon-edit-2 mr-2"></i>@translate(Details)</a>

                                            <a class="dropdown-item" 
                                                href="javascript:;"
                                                onclick="forModal('{{ route('student.enroll.courses.modal', $item->user_id) }}', '@translate(Pelatihan yang diikuti)')">
                                            <i class="feather icon-edit-2 mr-2"></i>@translate(Pelatihan)</a>
                                    </div>

                                </div> -->
                        <!-- </div> -->
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
</div>

@endsection