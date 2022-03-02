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
                                <input type="text" name="search" class="form-control col-12"
                                    placeholder="Nama / NIK" value="{{ Request::get('search') }}">
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
                                <option value="Tes Tulis">Tes Tulis</option>
                                <option value="Tes Wawancara">Tes Wawancara</option>
                                <option value="Pendaftaran Ulang">Pendaftaran Ulang</option>
                                <option value="Terdaftar">Terdaftar</option>
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
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th> </th>
                            <th width="100">@translate(Gambar)</th>
                            <th>@translate(User Name)</th>
                            <th>@translate(NIK)</th>
                            <th>Status</th>
                            <th>@translate(Logbook)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $item)
                            <tr>
                                <td><input type="checkbox" :value="{{ $item->enrollment_id }}" name="enrollment_id[]"
                                        v-model="enrollmentSelected" class="form-check-input"
                                        id="checkbox-{{ $item->id }}" @if (strtotime($course->berakhir_pendaftaran) > time()) disabled @endif>
                                </td>
                                <td>
                                    @if ($item->image != null)
                                        <img src="{{ filePath($item->image) }}"
                                            class="img-thumbnail rounded-circle avatar-lg"><br />
                                    @else
                                        <img src="#" class="img-thumbnail rounded-circle avatar-lg" alt="avatar"><br />
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
                                    @if (in_array($item->status, ['Terdaftar', 'Lulus']))
                                        <button class="btn btn-primary" type="button"
                                            onclick="forModal('{{ route('student.logbook.courses.modal', ['course_id' => $course_id, 'user_id' => $item->user_id]) }}', 'Logbook Siswa')">
                                            @translate(Lihat)</button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td>
                                    <h3 class="text-center">Tidak Ada Data Ditemukan</h3>
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
        Vue.createApp({
            data() {
                return {
                    title: 'Tes',
                    enrollmentSelected: [],
                    status: '',
                    mounted: false
                }
            },
            mounted() {
                this.mounted = true
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
                onSubmit() {
                    document.getElementById('form-enrollment').submit()
                }
            }
        }).mount('#app')
    </script>
@endsection
