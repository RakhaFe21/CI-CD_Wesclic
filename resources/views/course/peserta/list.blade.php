@extends('layouts.master')
@section('title', 'Peserta Pelatihan')
@section('parentPageTitle', 'All Student')
@section('content')
    <div class="card mx-2 mb-3" id="app">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="">
                <h3>List Siswa Pelatihan</h3>
                <h5>{{ $course->title }}</h5>
                <div><i class="fa fa-calendar"></i> {{ date('d M Y', strtotime($course->mulai_pendaftaran)) }} s/d
                    {{ date('d M Y', strtotime($course->berakhir_pendaftaran)) }}</div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12" placeholder="Nama / NIK"
                                    value="{{ Request::get('search') }}">
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
            <form action="{{ route('course.enrollment.status-update', ['course_id' => $course->id]) }}" method="post"
                enctype="multipart/form-data" id="form-enrollment">
                @csrf
                @method('PUT')
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                {{-- @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif --}}
            
                @if (auth()->user()->user_type != 'Executive')
                <div class="row align-items-end" style="display: none" v-show="mounted">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Perbarui Status</label>
                                    <select name="status" id="status" class="form-control" v-model="status">
                                        <option value="">-- Pilih --</option>
                                        {{-- <option :value="statusItem" v-for="(statusItem, sIndex) in statusOption"
                                            :key="'s'+sIndex" v-text="statusItem"></option> --}}
                                        <option value="Tes Tulis" @if($course['has_tes_tulis'] == false) hidden @endif>Tes Tulis</option>
                                        <option value="Tes Wawancara" @if($course['has_tes_wawancara'] == false) hidden @endif>Tes Wawancara</option>
                                        <option value="Pendaftaran Ulang" @if($course['has_pendaftaran_ulang'] == false) hidden @endif>Pendaftaran Ulang</option>
                                        <option value="Terdaftar">Terdaftar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">&nbsp;</label>
                                <button type="button" class="btn btn-primary d-block" id="apply-button"
                                    :disabled="!allowApply" data-toggle="modal" data-target="#modalApply"
                                    @click.prevent>Terapkan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-primary d-inline-block" id="invite-button" data-toggle="modal"
                            data-target="#modal-invite"><i class="fa fa-user-plus fa-fw"></i> Tambah Peserta</button>
                    </div>
                </div>
                @endif

                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                            aria-controls="pending" aria-selected="true" @click="changeTab('Pending')">Pending <span
                                class="badge badge-pills badge-warning">{{ $students['pending']->count() }}</span></a>
                    </li>
                    @if ($course['has_tes_tulis'] == true)
                        <li class="nav-item">
                            <a class="nav-link" id="tes_tulis-tab" data-toggle="tab" href="#tes_tulis" role="tab"
                                aria-controls="tes_tulis" aria-selected="false" @click="changeTab('Tes Tulis')">Tes Tulis <span
                                    class="badge badge-pills badge-info">{{ $students['tes_tulis']->count() }}</span></a>
                        </li>
                    @endif
                    @if ($course['has_tes_wawancara'] == true)
                        <li class="nav-item">
                            <a class="nav-link" id="tes_wawancara-tab" data-toggle="tab" href="#tes_wawancara" role="tab"
                                aria-controls="tes_wawancara" aria-selected="false" @click="changeTab('Tes Wawancara')">Tes
                                Wawancara <span
                                    class="badge badge-pills badge-info">{{ $students['tes_wawancara']->count() }}</span></a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="gagal-tab" data-toggle="tab" href="#gagal" role="tab"
                            aria-controls="gagal" aria-selected="false" @click="changeTab('Gagal')">Gagal <span
                                class="badge badge-pills badge-danger">{{ $students['gagal']->count() }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="peserta_cadangan-tab" data-toggle="tab" href="#peserta_cadangan"
                            role="tab" aria-controls="peserta_cadangan" aria-selected="false"
                            @click="changeTab('Peserta Cadangan')">Peserta Cadangan <span
                                class="badge badge-pills badge-warning">{{ $students['peserta_cadangan']->count() }}</span></a>
                    </li>
                    @if ($course['has_pendaftaran_ulang'] == true)
                        <li class="nav-item">
                            <a class="nav-link" id="pendaftaran_ulang-tab" data-toggle="tab" href="#pendaftaran_ulang"
                                role="tab" aria-controls="pendaftaran_ulang" aria-selected="false"
                                @click="changeTab('Pendaftaran Ulang')">Pendaftaran Ulang <span
                                    class="badge badge-pills badge-success">{{ $students['pendaftaran_ulang']->count() }}</span></a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="terdaftar-tab" data-toggle="tab" href="#terdaftar" role="tab"
                            aria-controls="terdaftar" aria-selected="false" @click="changeTab('Terdaftar')">Terdaftar <span
                                class="badge badge-pills badge-primary">{{ $students['terdaftar']->count() }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="lulus-tab" data-toggle="tab" href="#lulus" role="tab"
                            aria-controls="lulus" aria-selected="false" @click="changeTab('Lulus')">Lulus <span
                                class="badge badge-pills badge-success">{{ $students['lulus']->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['pending'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected" class="form-check-input"
                                                id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['pending']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tes_tulis" role="tabpanel" aria-labelledby="tes_tulis-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Sesi Tes Tulis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['tes_tulis'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected" class="form-check-input"
                                                id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                $sesi_tes_tulis = DB::table('kursus_sesi_enrollment')
                                                    ->where('id_enrollment', $item->enrollment_id)
                                                    ->where('nama_jadwal', 'Tes Tulis')
                                                    ->first();
                                            @endphp
                                            @if ($sesi_tes_tulis)
                                                <ul class="text-left list-unstyled">
                                                    <li><i class="fa fa-calendar"></i>
                                                        {{ $sesi_tes_tulis->tanggal_sesi }}
                                                    </li>
                                                    <li><i class="fa fa-clock-o"></i> {{ $sesi_tes_tulis->jam_sesi }}
                                                    </li>
                                                    <li><i class="fa fa-map-marker"></i>
                                                        {{ $sesi_tes_tulis->lokasi_sesi }}
                                                    </li>
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['tes_tulis']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tes_wawancara" role="tabpanel" aria-labelledby="tes_wawancara-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Sesi Tes Wawancara</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['tes_wawancara'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected" class="form-check-input"
                                                id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                $sesi_tes_wawancara = DB::table('kursus_sesi_enrollment')
                                                    ->where('id_enrollment', $item->enrollment_id)
                                                    ->where('nama_jadwal', 'Tes Wawancara')
                                                    ->first();
                                            @endphp
                                            @if ($sesi_tes_wawancara)
                                                <ul class="text-left list-unstyled">
                                                    <li><i class="fa fa-calendar"></i>
                                                        {{ $sesi_tes_wawancara->tanggal_sesi }}
                                                    </li>
                                                    <li><i class="fa fa-clock-o"></i>
                                                        {{ $sesi_tes_wawancara->jam_sesi }}
                                                    </li>
                                                    <li><i class="fa fa-map-marker"></i>
                                                        {{ $sesi_tes_wawancara->lokasi_sesi }}
                                                    </li>
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['tes_wawancara']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="gagal" role="tabpanel" aria-labelledby="gagal-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['gagal'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected" class="form-check-input"
                                                id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['gagal']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="peserta_cadangan" role="tabpanel"
                        aria-labelledby="peserta_cadangan-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['peserta_cadangan'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected" class="form-check-input"
                                                id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['peserta_cadangan']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pendaftaran_ulang" role="tabpanel"
                        aria-labelledby="pendaftaran_ulang-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Sesi Pendaftaran Ulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['pendaftaran_ulang'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected"
                                                class="form-check-input" id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                $sesi_pendaftaran_ulang = DB::table('kursus_sesi_enrollment')
                                                    ->where('id_enrollment', $item->enrollment_id)
                                                    ->where('nama_jadwal', 'Pendaftaran Ulang')
                                                    ->first();
                                            @endphp
                                            @if ($sesi_pendaftaran_ulang)
                                                <ul class="text-left list-unstyled">
                                                    <li><i class="fa fa-calendar"></i>
                                                        {{ $sesi_pendaftaran_ulang->tanggal_sesi }}</li>
                                                    <li><i class="fa fa-clock-o"></i>
                                                        {{ $sesi_pendaftaran_ulang->jam_sesi }}
                                                    </li>
                                                    <li><i class="fa fa-map-marker"></i>
                                                        {{ $sesi_pendaftaran_ulang->lokasi_sesi }}</li>
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['pendaftaran_ulang']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="terdaftar" role="tabpanel" aria-labelledby="terdaftar-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                    <th>Logbook</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['terdaftar'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected"
                                                class="form-check-input" id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="forModal('{{ route('student.logbook.courses.modal', ['course_id' => $course_id, 'user_id' => $item->user_id]) }}', 'Logbook Siswa')">
                                                @translate(Lihat)</button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['terdaftar']->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="lulus" role="tabpanel" aria-labelledby="terdaftar-tab">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th width="100">Gambar</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                    <th>Logbook</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students['lulus'] as $item)
                                    <tr>
                                        <td><input type="checkbox" :value="{{ $item->enrollment_id }}"
                                                name="enrollment_id[]" v-model="enrollmentSelected"
                                                class="form-check-input" id="checkbox-{{ $item->id }}"
                                                @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                        </td>
                                        <td>
                                            @if ($item->image != null)
                                                <img src="{{ filePath($item->image) }}"
                                                    class="img-thumbnail rounded-circle avatar-lg"><br />
                                            @else
                                                <img src="#" class="img-thumbnail rounded-circle avatar-lg"
                                                    alt="avatar"><br />
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->nik ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="forModal('{{ route('student.logbook.courses.modal', ['course_id' => $course_id, 'user_id' => $item->user_id]) }}', 'Logbook Siswa')">
                                                @translate(Lihat)</button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {{ $students['lulus']->links() }}
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal fade" id="modalApply" tabindex="-1" role="dialog" aria-labelledby="modalApplyLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalApplyLabel">Perbarui Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin perbarui status pelatihan siswa menjadi <b v-text="status"></b> ?
                    </div>
                    {{-- <input type="hidden" name="enrollment_id[]" :value="enrollmentSelected"> --}}
                    {{-- <input type="hidden" name="status" :value="status"> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" @click.prevent="onSubmit">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-invite" tabindex="-1" role="dialog" aria-labelledby="modal-inviteLabel"
        aria-hidden="true">
        <form action="{{ route('course.enrollment.add-student', ['course_id' => $course_id]) }}" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-inviteLabel">Tambah Peserta ke Pelatihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled">
                            @foreach ($studentEnrolledOrNotList as $item)
                                <li>
                                    <label class="mb-0" for="check-{{ $item->id }}" {!! $item->enrolled ? 'style="text-decoration: line-through; color: #007bff"' : '' !!}>
                                        <input id="check-{{ $item->id }}" type="checkbox" name="student_add[]"
                                            value="{{ $item->id }}" {{$item->enrolled ? 'disabled checked' : ''}} class="mr-1">
                                        {{ $item->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('page-script')
    <script>
        // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // e.target // newly activated tab
        // e.relatedTarget // previous active tab
        // console.log(e.target)
        // })
        
        Vue.createApp({
            data() {
                return {
                    title: 'Tes',
                    enrollmentSelected: [],
                    status: '',
                    mounted: false,
                    statusOption: [
                        // 'Tes Tulis',
                        // 'Tes Wawancara',
                        // 'Pendaftaran Ulang',
                        // 'Terdaftar',
                        // 'Lulus',
                    ],
                    currentTab: 'Pending'
                }
            },
            mounted() {
                this.mounted = true
                this.changeTab('Pending')
            },
            computed: {
                allowApply() {
                    if (this.enrollmentSelected.length > 0 && this.status) {
                        return true
                    }
                    return false
                }
            },
            methods: {
                changeTab(tab) {
                    switch (tab) {
                        case 'Pending':
                            this.statusOption = [
                                'Tes Tulis',
                            ]
                            break;
                        case 'Tes Tulis':
                            this.statusOption = [
                                'Tes Wawancara',
                                'Gagal',
                            ]
                            break;
                        case 'Tes Wawancara':
                            this.statusOption = [
                                'Pendaftaran Ulang',
                                'Peserta Cadangan',
                                'Gagal',
                            ]
                            break;
                        case 'Peserta Cadangan':
                            this.statusOption = [
                                'Pendaftaran Ulang',
                                'Terdaftar',
                            ]
                            break;
                        case 'Pendaftaran Ulang':
                            this.statusOption = [
                                'Terdaftar',
                            ]
                            break;
                        case 'Terdaftar':
                            this.statusOption = [
                                'Lulus',
                            ]
                            break;
                        case 'Lulus':
                            this.statusOption = [
                                'Sudah Ambil Sertifikat BLK',
                                'Sudah Ambil Sertifikat BNSP',
                                'Sudah Ambil Sertifikat BLK & BNSP',
                            ]
                            break;
                        default:
                            this.statusOption = []
                            break;
                    }
                },
                onSubmit() {
                    document.getElementById('form-enrollment').submit()
                }
            }
        }).mount('#app')
    </script>
@endsection
