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

                <div class="row" style="display: none" v-show="mounted">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Perbarui Status</label>
                            <select name="status" id="status" class="form-control" v-model="status">
                                <option value="">-- Pilih --</option>
                                <option :value="statusItem" v-for="(statusItem, sIndex) in statusOption" :key="'s'+sIndex"
                                    v-text="statusItem"></option>
                                {{-- <option value="Tes Wawancara">Tes Wawancara</option> --}}
                                {{-- <option value="Pendaftaran Ulang">Pendaftaran Ulang</option> --}}
                                {{-- <option value="Terdaftar">Terdaftar</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="">&nbsp;</label>
                        <button type="button" class="btn btn-primary d-block" id="apply-button" :disabled="!allowApply"
                            data-toggle="modal" data-target="#modalApply" @click.prevent>Terapkan</button>
                    </div>
                </div>
                <span v-text="enrollmentSelected"></span>

                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                            aria-controls="pending" aria-selected="true" @click="changeTab('Pending')">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tes_tulis-tab" data-toggle="tab" href="#tes_tulis" role="tab"
                            aria-controls="tes_tulis" aria-selected="false" @click="changeTab('Tes Tulis')">Tes Tulis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tes_wawancara-tab" data-toggle="tab" href="#tes_wawancara" role="tab"
                            aria-controls="tes_wawancara" aria-selected="false" @click="changeTab('Tes Wawancara')">Tes
                            Wawancara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pendaftaran_ulang-tab" data-toggle="tab" href="#pendaftaran_ulang"
                            role="tab" aria-controls="pendaftaran_ulang" aria-selected="false"
                            @click="changeTab('Pendaftaran Ulang')">Pendaftaran Ulang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="terdaftar-tab" data-toggle="tab" href="#terdaftar" role="tab"
                            aria-controls="terdaftar" aria-selected="false" @click="changeTab('Terdaftar')">Terdaftar</a>
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

                    </div>
                    <div class="tab-pane fade" id="tes_wawancara" role="tabpanel" aria-labelledby="tes_wawancara-tab">

                    </div>
                    <div class="tab-pane fade" id="pendaftaran_ulang" role="tabpanel"
                        aria-labelledby="pendaftaran_ulang-tab">

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
                            {{ $students['pending']->links() }}
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

                        default:
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
