@extends('layouts.master')
@section('title', 'Course Edit')
@section('parentPageTitle', 'Course')
@section('css-link')
    @include('layouts.include.form.form_css')
@stop
@section('page-style')
@stop

@section('content')
    <!-- BEGIN:content -->
    <div class="card m-b-30" id="app">
        <div class="card-body">
            <h4>@translate(Data Pelatihan)</h4>
            <form class="form-validate" action="{{ route('course.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $each_course->id }}">
                {{-- Course Title --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-title">
                        @translate(Judul Pelatihan) <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" required value="{{ $each_course->title }}"
                            class="form-control @error('title') is-invalid @enderror" id="val-title" name="title"
                            placeholder="Enter Course Title" aria-required="true" autofocus
                            {{ Auth::user()->user_type == 'Admin' ? '' : 'readonly' }}>
                        @error('title')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>
                {{-- Slug --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-slug">
                        @translate(Slug) <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" required value="{{ $each_course->slug }}"
                            class="form-control @error('slug') is-invalid @enderror" id="val-slug" name="slug"
                            placeholder="Enter Slug" aria-required="true"
                            {{ Auth::user()->user_type == 'Admin' ? '' : 'readonly' }}>
                        <span id="error_email"></span>
                        @error('slug')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-suggestions">
                        @translate(Deskripsi)</label>
                    <div class="col-lg-9">
                        @if (\Auth::user()->user_type == 'Admin')
                            <textarea required
                                class="form-control summernote @error('short_description') is-invalid @enderror"
                                name="short_description" rows="5">{!! $each_course->short_description !!}</textarea>
                            @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong> </span>
                            @enderror
                        @else
                            {!! $each_course->short_description !!}
                        @endif

                    </div>
                </div>
                {{-- Course Thumbnail --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="img">
                        @translate(Course Thumbnail) <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <img src="{{ filePath($each_course->image) }}" width="200" height="auto" alt="photo">
                        <br>

                        <input type="hidden" required value="{{ $each_course->image }}"
                            class="form-control course_image @error('image') is-invalid @enderror" id="val-img"
                            name="image">
                        <img class="course_thumb_preview rounded shadow-sm d-none" src="" alt="#Course thumbnail"
                            width="200" height="auto">
                        @error('image')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror

                        <input type="hidden" name="course_thumb_url" class="course_thumb_url" value="">
                        <br>

                        @if (MediaActive())
                            {{-- media --}}
                            <a href="javascript:void()" onclick="openNav('{{ route('media.slide') }}', 'thumbnail')"
                                class="btn btn-primary media-btn mt-2 p-2">Upload From Media <i
                                    class="fa fa-cloud-upload ml-2" aria-hidden="true"></i> </a>
                        @endif

                    </div>
                </div>
                {{-- Category --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-category_id">
                        @translate(Category) <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select class="form-control lang @error('category_id') is-invalid @enderror" id="val-category_id"
                            name="category_id" required {{ Auth::user()->user_type == 'Admin' ? '' : 'readonly' }}>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $each_course->category_id == $category->id ? 'selected' : null }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- tahapan & jadwal seleksi --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-suggestions">
                        @translate(tahapan & jadwal seleksi)</label>
                    <div class="col-lg-9">
                        @if (\Auth::user()->user_type == 'Admin')
                            <textarea required
                                class="form-control summernote @error('big_description') is-invalid @enderror"
                                name="big_description" rows="5">{!! $each_course->big_description !!}</textarea>
                            @error('big_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong> </span>
                            @enderror
                        @else
                            {!! $each_course->big_description($each_course->big_description) !!}
                        @endif

                    </div>
                </div>
                {{-- tahapan pelatihan --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-suggestions">
                        @translate(tahapan pelatihan)</label>
                    <div class="col-lg-9">
                        @if (\Auth::user()->user_type == 'Admin')
                            <textarea required
                                class="form-control summernote @error('tahapan_pelatihan') is-invalid @enderror"
                                name="tahapan_pelatihan" rows="5">{!! $each_course->tahapan_pelatihan !!}</textarea>
                            @error('tahapan_pelatihan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong> </span>
                            @enderror
                        @else
                            {!! $each_course->big_description($each_course->tahapan_pelatihan) !!}
                        @endif

                    </div>
                </div>
                {{-- Type pelatihan --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-provider">
                        @translate(Type pelatihan) <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select class="form-control lang @error('level') is-invalid @enderror" id="val-provider"
                            name="level" required {{ Auth::user()->user_type == 'Admin' ? '' : 'readonly' }}>
                            <option value="Terbuka" {{ $each_course->level === 'Terbuka' ? 'selected' : '' }}>
                                @translate(Terbuka)
                            </option>
                            <option value="Tertutup" {{ $each_course->level === 'Tertutup' ? 'selected' : '' }}>
                                @translate(Tertutup)
                            </option>
                        </select>
                    </div>
                    @error('level')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        <strong>@translate(Jadwal Pendaftaran :)</label></strong>
                    <div class="col-lg-9">
                        <div class="switchery-list">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Mulai)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input required type="date" value="{{ $each_course->mulai_pendaftaran }}"
                                name="mulai_pendaftaran"
                                class="form-control @error('mulai_pendaftaran') is-invalid @enderror">
                            @error('mulai_pendaftaran')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Berakhir)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input required type="date" value="{{ $each_course->berakhir_pendaftaran }}"
                                name="berakhir_pendaftaran"
                                class="form-control @error('berakhir_pendaftaran') is-invalid @enderror">
                            @error('berakhir_pendaftaran')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Jumlah Peserta --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jumlah Peserta)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" v-model="jumlah_peserta" />
                            @error('jumlah_peserta')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        <strong>@translate(Jadwal Seleksi :)</label></strong>
                    <div class="col-lg-9">
                        <div class="switchery-list">

                        </div>
                    </div>
                </div>

                {{-- Tes Tulis --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="has_tes_tulis">Tes Tulis</label>
                    <div class="col-lg-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="has_tes_tulis" id="has_tes_tulis"
                                v-model="testu_enable">
                            <label class="custom-control-label" for="has_tes_tulis"></label>
                        </div>
                    </div>
                </div>


                <div id="auto_hide" v-if="testu_enable">

                    {{-- TT - Jumlah Sesi Per Hari --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jumlah Sesi Per Hari)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="testu_jumlah_sesi_perhari" id="testu_jumlah_sesi_perhari"
                                    v-model="testu_jumlah_sesi_perhari" />
                                @error('testu_jumlah_sesi_perhari')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TT - Durasi Per Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Durasi Per Sesi) (Menit)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="testu_durasi_per_sesi" id="testu_durasi_per_sesi"
                                    v-model="testu_durasi_per_sesi" />
                                @error('testu_durasi_per_sesi')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TT - Jumlah Perserta Per Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jumlah Peserta Per Sesi)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="testu_jumlah_peserta_persesi" id="testu_jumlah_peserta_persesi"
                                    v-model="testu_jumlah_peserta_persesi" />
                                @error('testu_jumlah_peserta_persesi')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TT - Tanggal Mulai --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Tanggal Mulai)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="date" name="testu_tanggal_mulai" id="testu_tanggal_mulai"
                                    v-model="testu_tanggal_mulai" />
                                @error('testu_tanggal_mulai')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TT - Jam Mulai --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jam Mulai)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="time" name="testu_jam_mulai" id="testu_jam_mulai" v-model="testu_jam_mulai" />
                                @error('testu_jam_mulai')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-sm btn-primary mt-3" type="button"
                                @click.prevent="generateJadwalTulis">Generate Sesi</button>
                        </div>
                    </div>

                    {{-- Tes Tulis Sesi --}}
                    <div class="tes-tulis tes-tulis-row" v-for="(sesi, s_index) in testu_data_sesi" :key="s_index">

                        <div class="text-h6" v-text="sesi.nama_sesi"></div>

                        {{-- Nama Sesi --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Nama Sesi)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" v-model="sesi.nama_sesi" name="testu_sesi_nama[]"
                                        class="form-control">
                                    <input type="hidden" v-model="sesi.id" name="testu_sesi_id[]" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Tanggal)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="date" v-model="sesi.tanggal_sesi" name="testu_sesi_tanggal[]"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Jam --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Jam)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="time" v-model="sesi.jam_sesi" name="testu_sesi_jam[]"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Lokasi)</label>
                            <div class="col-lg-7">
                                <div class="input-group mb-3">
                                    <input type="text" v-model="sesi.lokasi_sesi" name="testu_sesi_lokasi[]"
                                        class="form-control">
                                    {{-- <input type="hidden" v-model="sesi.nama_sesi" name="testu_sesi_nama[]" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-danger" type="button"
                                    @click.prevent="deleteSesi(sesi, s_index)">
                                    <i class="fa fa-spin fa-spinner fa-fw" v-if="loading"></i>
                                    <i class="fa fa-trash fa-fw" v-else></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 row mb-4" v-if="testu_data_sesi && testu_data_sesi.length > 0">
                        {{-- <div class="mt-3 row mb-4" v-if="testu_data_sesi"> --}}
                        <div class="col-lg-3 col-form-label"></div>
                        <div class="col-lg-9">
                            <button class="btn btn-sm btn-primary" type="button" @click.prevent="tambahSesiTulis"><i
                                    class="fa fa-plus"></i> Tambah Sesi</button>
                        </div>
                    </div>

                </div>

                {{-- Tes Wawancara --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="has_tes_wawancara">Tes Wawancara</label>
                    <div class="col-lg-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="has_tes_wawancara"
                                id="has_tes_wawancara" v-model="teswa_enable">
                            <label class="custom-control-label" for="has_tes_wawancara"></label>
                        </div>
                    </div>
                </div>


                <div id="auto_hide2" v-if="teswa_enable">

                    {{-- TW - Jumlah Sesi Per Hari --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jumlah Sesi Per Hari)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="teswa_jumlah_sesi_perhari" id="teswa_jumlah_sesi_perhari"
                                    v-model="teswa_jumlah_sesi_perhari" />
                                @error('teswa_jumlah_sesi_perhari')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TW - Durasi Per Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Durasi Per Sesi) (Menit)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="teswa_durasi_per_sesi" id="teswa_durasi_per_sesi"
                                    v-model="teswa_durasi_per_sesi" />
                                @error('teswa_durasi_per_sesi')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TW - Jumlah Perserta Per Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jumlah Peserta Per Sesi)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="number" name="teswa_jumlah_peserta_persesi" id="teswa_jumlah_peserta_persesi"
                                    v-model="teswa_jumlah_peserta_persesi" />
                                @error('teswa_jumlah_peserta_persesi')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TW - Tanggal Mulai --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Tanggal Mulai)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="date" name="teswa_tanggal_mulai" id="teswa_tanggal_mulai"
                                    v-model="teswa_tanggal_mulai" />
                                @error('teswa_tanggal_mulai')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TW - Jam Mulai --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">
                            @translate(Jam Mulai)</label>
                        <div class="col-lg-9">
                            <div class="switchery-list">
                                <input type="time" name="teswa_jam_mulai" id="teswa_jam_mulai" v-model="teswa_jam_mulai" />
                                @error('teswa_jam_mulai')
                                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-sm btn-primary mt-3" type="button"
                                @click.prevent="generateJadwalWawancara">Generate Sesi</button>
                        </div>
                    </div>

                    {{-- Tes Tulis Sesi --}}
                    <div class="tes-wawancara tes-wawancara-row" v-for="(sesi, s_index) in teswa_data_sesi" :key="s_index">

                        <div class="text-h6" v-text="sesi.nama_sesi"></div>

                        {{-- Nama Sesi --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Nama Sesi)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" v-model="sesi.nama_sesi" name="teswa_sesi_nama[]"
                                        class="form-control">
                                    <input type="hidden" v-model="sesi.id" name="teswa_sesi_id[]" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Tanggal)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="date" v-model="sesi.tanggal_sesi" name="teswa_sesi_tanggal[]"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Jam --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Jam)</label>
                            <div class="col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="time" v-model="sesi.jam_sesi" name="teswa_sesi_jam[]"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">
                                @translate(Lokasi)</label>
                            <div class="col-lg-7">
                                <div class="input-group mb-3">
                                    <input type="text" v-model="sesi.lokasi_sesi" name="teswa_sesi_lokasi[]"
                                        class="form-control">
                                    {{-- <input type="hidden" v-model="sesi.nama_sesi" name="testu_sesi_nama[]" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-danger" type="button"
                                    @click.prevent="deleteSesi(sesi, s_index)">
                                    <i class="fa fa-spin fa-spinner fa-fw" v-if="loading"></i>
                                    <i class="fa fa-trash fa-fw" v-else></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 row mb-4" v-if="teswa_data_sesi && teswa_data_sesi.length > 0">
                        {{-- <div class="mt-3 row mb-4" v-if="teswa_data_sesi"> --}}
                        <div class="col-lg-3 col-form-label"></div>
                        <div class="col-lg-9">
                            <button class="btn btn-sm btn-primary" type="button" @click.prevent="tambahSesiWawancara"><i
                                    class="fa fa-plus"></i> Tambah Sesi</button>
                        </div>
                    </div>

                </div>

                <div class="field_wrapper">
                    <div class="form-group row" v-for="(log, l_index) in logbook" :key="'L'+l_index">
                        <label class="col-lg-3 col-form-label" for="val-logbook">
                            <div v-if="l_index == 0">Logbook <span class="text-danger">*</span></div>
                        </label>
                        <div class="col-lg-8">
                            <input type="text" required class="form-control" id="val-logbook" name="logbook[]" autofocus
                                v-model="log.name">
                            <input type="hidden" class="form-control" name="logbook_id[]" autofocus v-model="log.id">
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="btn btn-danger" id="delete_button" title="Delete logbook"
                                v-if="l_index != 0" @click.prevent="deleteLogbook(log, l_index)">
                                <i class="fa fa-spin fa-spinner fa-fw" v-if="loading"></i>
                                <i class="la la-minus" v-else></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-9">
                            <button type="button" class="btn btn-primary" id="add_button" title="Add logbook"
                                @click.prevent="tambahLogbook"><i class="la la-plus"></i></button>
                        </div>
                    </div>
                </div>

                <hr>

                @if (Auth::user()->user_type === 'Admin')
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                @endif


            </form>
        </div>
    </div>

    <!-- END:content -->
@endsection

@section('js-link')
    @include('layouts.include.form.form_js')
@stop

@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/js/custom/course.js') }}"></script>
    <script>
        const hasTesTulis = {{ $each_course->has_tes_tulis }};
        let dataJadwalTesTulis = {!! $jadwal_tes_tulis !!};
        dataJadwalTesTulis = dataJadwalTesTulis != null ? dataJadwalTesTulis : {}
        const hasTesWawancara = {{ $each_course->has_tes_wawancara }};
        let dataJadwalTesWawancara = {!! $jadwal_tes_wawancara !!};
        dataJadwalTesWawancara = dataJadwalTesWawancara != null ? dataJadwalTesWawancara : {}

        console.log(dataJadwalTesTulis)
        console.log(dataJadwalTesWawancara)

        let dataLogbook = {!! $logbook !!};
        dataLogbook = dataLogbook != null ? dataLogbook : []
        Vue.createApp({
            data() {
                return {
                    title: 'Hello Vue!',
                    loading: false,
                    jumlah_peserta: {{ $each_course->jumlah_peserta }},
                    testu_enable: false,
                    testu_jumlah_sesi_perhari: dataJadwalTesTulis.jumlah_sesi_perhari,
                    testu_durasi_per_sesi: dataJadwalTesTulis.durasi_persesi,
                    testu_jumlah_peserta_persesi: dataJadwalTesTulis.jumlah_peserta_persesi,
                    testu_tanggal_mulai: dataJadwalTesTulis.tanggal_mulai,
                    testu_jam_mulai: dataJadwalTesTulis.jam_mulai,
                    testu_data_sesi: [],
                    tes_tulis_show: false,
                    // jumlah_peserta_wawancara: 50,
                    teswa_enable: hasTesWawancara,
                    teswa_jumlah_sesi_perhari: dataJadwalTesWawancara.jumlah_sesi_perhari,
                    teswa_durasi_per_sesi: dataJadwalTesWawancara.durasi_persesi,
                    teswa_jumlah_peserta_persesi: dataJadwalTesWawancara.jumlah_peserta_persesi,
                    teswa_tanggal_mulai: dataJadwalTesWawancara.tanggal_mulai,
                    teswa_jam_mulai: dataJadwalTesWawancara.jam_mulai,
                    teswa_data_sesi: [],

                    logbook: dataLogbook
                }
            },
            mounted() {
                // elems.forEach(function(html) {
                //     console.log(html)
                //     var switchery = new Switchery(html, { color: '#43d187' });
                // });
                this.testu_enable = hasTesTulis == 1 ? true : false
                this.testu_data_sesi = dataJadwalTesTulis.sesi ? dataJadwalTesTulis.sesi : []
                this.teswa_enable = hasTesWawancara == 1 ? true : false
                this.teswa_data_sesi = dataJadwalTesWawancara.sesi ? dataJadwalTesWawancara.sesi : []
            },
            watch: {
                testu_enable: function(value) {
                    console.log(value)
                },
                teswa_enable: function(value) {
                    console.log(value)
                }
            },
            methods: {

                generateJadwalTulis() {

                    if (this.jumlah_peserta < 1) {
                        return alert('Jumlah Peserta wajib diisi!');
                    }

                    const jumlah_hari = Math.ceil(this.jumlah_peserta / (this.testu_jumlah_sesi_perhari * this
                        .testu_jumlah_peserta_persesi))
                    const jumlah_peserta_sisa = this.jumlah_peserta % (this.testu_jumlah_sesi_perhari * this
                        .testu_jumlah_peserta_persesi)

                    console.log('jumlah_hari', jumlah_hari)
                    console.log('jumlah_peserta_sisa', jumlah_peserta_sisa)

                    let hari = []
                    let last_index = jumlah_hari - 1
                    for (let i = 0; i < jumlah_hari; i++) {
                        if (i !== last_index && jumlah_peserta_sisa > 0) {
                            if (i == 0) {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.testu_jumlah_sesi_perhari * this
                                        .testu_jumlah_peserta_persesi,
                                    tanggal: moment(this.testu_tanggal_mulai).add(0, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.testu_jam_mulai
                                })
                            } else {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.testu_jumlah_sesi_perhari * this
                                        .testu_jumlah_peserta_persesi,
                                    tanggal: moment(this.testu_tanggal_mulai).add(i, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.testu_jam_mulai
                                })
                            }
                        } else if (jumlah_hari == 1) {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: this.testu_jumlah_sesi_perhari * this.testu_jumlah_peserta_persesi,
                                tanggal: moment(this.testu_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.testu_jam_mulai
                            })
                        } else {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: jumlah_peserta_sisa,
                                tanggal: moment(this.testu_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.testu_jam_mulai
                            })
                        }
                    }
                    console.log('hari', hari)

                    let sesi = [],
                        nomor = 1;
                    for (let x = 0; x < hari.length; x++) {
                        const perhari = hari[x];
                        const sesi_per_hari = perhari.jumlah_peserta / this.testu_jumlah_peserta_persesi
                        let durasi = 0;
                        for (let z = 0; z < sesi_per_hari; z++) {
                            let tanggal = perhari.tanggal + ' ' + perhari.jam_mulai
                            sesi.push({
                                nama_sesi: `Hari ${x+1} Sesi ${z+1}`,
                                tanggal_sesi: perhari.tanggal,
                                jam_sesi: moment(tanggal).add(durasi, 'm').format('HH:mm'),
                                lokasi_sesi: '-'
                            })
                            durasi += this.testu_durasi_per_sesi
                        }
                    }

                    console.log('sesi', sesi)
                    this.testu_data_sesi = sesi

                },

                generateJadwalWawancara() {

                    if (this.jumlah_peserta < 1) {
                        return alert('Jumlah Peserta wajib diisi!');
                    }

                    const jumlah_hari = Math.ceil(this.jumlah_peserta / (this.teswa_jumlah_sesi_perhari * this
                        .teswa_jumlah_peserta_persesi))
                    const jumlah_peserta_sisa = this.jumlah_peserta % (this.teswa_jumlah_sesi_perhari * this
                        .teswa_jumlah_peserta_persesi)

                    console.log('jumlah_hari', jumlah_hari)
                    console.log('jumlah_peserta_sisa', jumlah_peserta_sisa)

                    let hari = []
                    let last_index = jumlah_hari - 1
                    for (let i = 0; i < jumlah_hari; i++) {
                        if (i !== last_index && jumlah_peserta_sisa > 0) {
                            if (i == 0) {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.teswa_jumlah_sesi_perhari * this
                                        .teswa_jumlah_peserta_persesi,
                                    tanggal: moment(this.teswa_tanggal_mulai).add(0, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.teswa_jam_mulai
                                })
                            } else {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.teswa_jumlah_sesi_perhari * this
                                        .teswa_jumlah_peserta_persesi,
                                    tanggal: moment(this.teswa_tanggal_mulai).add(i, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.teswa_jam_mulai
                                })
                            }
                        } else if (jumlah_hari == 1) {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: this.teswa_jumlah_sesi_perhari * this
                                    .teswa_jumlah_peserta_persesi,
                                tanggal: moment(this.teswa_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.teswa_jam_mulai
                            })
                        } else {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: jumlah_peserta_sisa,
                                tanggal: moment(this.teswa_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.teswa_jam_mulai
                            })
                        }
                    }
                    console.log('hari', hari)

                    let sesi = [],
                        nomor = 1;
                    for (let x = 0; x < hari.length; x++) {
                        const perhari = hari[x];
                        const sesi_per_hari = perhari.jumlah_peserta / this.teswa_jumlah_peserta_persesi
                        let durasi = 0;
                        for (let z = 0; z < sesi_per_hari; z++) {
                            let tanggal = perhari.tanggal + ' ' + perhari.jam_mulai
                            sesi.push({
                                nama_sesi: `Hari ${x+1} Sesi ${z+1}`,
                                tanggal_sesi: perhari.tanggal,
                                jam_sesi: moment(tanggal).add(durasi, 'm').format('HH:mm'),
                                lokasi_sesi: '-'
                            })
                            durasi += this.teswa_durasi_per_sesi
                        }
                    }

                    console.log('sesi', sesi)
                    this.teswa_data_sesi = sesi

                },

                tambahSesiTulis() {
                    this.testu_data_sesi.push({
                        nama_sesi: 'Sesi Baru',
                        tanggal: null,
                        jam: null,
                        lokasi: '-'
                    })
                },
                tambahSesiWawancara() {
                    this.teswa_data_sesi.push({
                        nama_sesi: 'Sesi Baru',
                        tanggal: null,
                        jam: null,
                        lokasi: '-'
                    })
                },

                deleteSesi(sesi, s_index) {

                    const r = confirm('Apakah anda yakin?')
                    if (!r) return

                    if (sesi.id == null) {
                        this.testu_data_sesi.splice(s_index, 1)
                    } else {


                        this.loading = true
                        api.delete('/api/v1/courses/sesi/' + sesi.id + '/delete')
                            .then(response => {
                                this.testu_data_sesi.splice(s_index, 1)
                                notification('Sesi berhasil dihapus!', 'success')
                            }).catch(error => {
                                console.log(error)
                                notification('Sesi gagal dihapus!', 'danger')
                            }).finally(() => {
                                this.loading = false
                            })

                    }

                },

                tambahLogbook() {
                    this.logbook.push({
                        name: '-'
                    })
                },
                deleteLogbook(logbook, l_index) {

                    const r = confirm('Apakah anda yakin?')
                    if (!r) return

                    if (logbook.id == null) {
                        this.logbook.splice(l_index, 1)
                    } else {

                        this.loading = true
                        api.delete('/api/v1/courses/logbook/' + logbook.id + '/delete')
                            .then(response => {
                                this.testu_data_sesi.splice(l_index, 1)
                                notification({
                                    message: 'Sesi berhasil dihapus!',
                                    type: 'success'
                                })
                            }).catch(error => {
                                console.log(error)
                                notification({
                                    message: 'Sesi gagal dihapus!',
                                    type: 'danger'
                                })
                            }).finally(() => {
                                this.loading = false
                            })

                    }

                },

            }
        }).mount('#app')
    </script>
@stop
