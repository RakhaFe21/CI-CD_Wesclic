@extends('layouts.master')
@section('title', 'Buat Pelatihan')
@section('parentPageTitle', 'Pelatihan')
@section('css-link')
@include('layouts.include.form.form_css')
@stop
@section('page-style')
@stop
@section('content')
<!-- BEGIN:content -->
<form action="{{ route('course.store') }}" method="post" enctype="multipart/form-data">
    <div class="card m-b-30" id="app">
        <h4 class="card-header">@translate(Tambah pelatihan baru)</h4>
        <div class="card-body mx-3">
            @csrf
            {{-- Course Title --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-title">
                    @translate(Nama Pelatihan) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" required value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror" id="val-title" name="title"
                        placeholder="@translate(Masukkan Judul Pelatihan)" aria-required="true" autofocus>
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
                    <input type="text" required value="{{ old('slug') }}"
                        class="form-control @error('slug') is-invalid @enderror" id="val-slug" name="slug"
                        aria-required="true">
                    <span id="error_email"></span>
                    @error('slug')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-suggestions">
                    @translate(Deskripsi)<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <textarea class="form-control summernote @error('short_description') is-invalid @enderror"
                        name="short_description" rows="5" required value="{{ old('short_description') }}"
                        aria-required="true">{!! old('short_description') !!}</textarea>
                    @error('short_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>

            {{-- Course Thumbnail --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-img">
                    @translate(Thumbnail Pelatihan) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="hidden" required value="{{ old('image') }}"
                        class="form-control course_image @error('image') is-invalid @enderror" id="val-img"
                        name="image">
                    <img class="w-50 course_thumb_preview rounded shadow-sm d-none" src="" alt="#Thumbnail Pelatihan">
                    @error('image')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror

                    <input type="hidden" name="course_thumb_url" class="course_thumb_url" value="">
                    <br>

                    {{-- <a href="javascript:void()" onclick="openNav('{{ route('media.slide') }}', 'thumbnail')"
                        class="btn btn-primary media-btn mt-2 p-2">Upload From Media <i class="fa fa-cloud-upload ml-2"
                            aria-hidden="true"></i> </a> --}}

                    @if (MediaActive())
                    {{-- media --}}
                    <a href="javascript:void()" onclick="openNav('{{ route('media.slide') }}', 'thumbnail')"
                        class="btn btn-primary media-btn mt-2 p-2">Upload From Media <i class="fa fa-cloud-upload ml-2"
                            aria-hidden="true"></i> </a>
                    @endif
                </div>
            </div>

            {{-- Category --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-category_id">
                    @translate(Kategori) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select class="form-control lang @error('category_id') is-invalid @enderror" id="val-category_id"
                        name="category_id" required>
                        <option value="" class="mb-2">
                            @translate(Kategori)</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                    @translate(Tahapan & jadwal seleksi)<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <textarea required="required"
                        class="form-control summernote @error('big_description') is-invalid @enderror"
                        name="big_description" rows="5">{{ old('big_description') }}</textarea>
                    @error('big_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>

            {{-- tahapan pelatihan --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-suggestions">
                    @translate(Tahapan pelatihan)<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <textarea required="required"
                        class="form-control summernote @error('tahapan_pelatihan') is-invalid @enderror"
                        name="tahapan_pelatihan" rows="5">{{ old('tahapan_pelatihan') }}</textarea>
                    @error('tahapan_pelatihan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>

            {{-- Type pelatihan --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-level">
                    @translate(Tipe pelatihan) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select class="form-control lang @error('level') is-invalid @enderror" id="val-level" name="level"
                        required>
                        <option value="">
                            @translate(Pilih Jenis Pelatihan)</option>
                        <option value="Terbuka">
                            @translate(Terbuka)</option>
                        <option value="Tertutup">
                            @translate(Tertutup)</option>
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
                        <input required type="date" value="{{ old('mulai_pendaftaran') }}" name="mulai_pendaftaran"
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
                        <input required type="date" value="{{ old('berakhir_pendaftaran') }}"
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
                        <input type="number" name="jumlah_peserta" id="jumlah_peserta" v-model="jumlah_peserta"
                            required />
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
                <label class="col-lg-3 col-form-label" for="is_free">
                    @translate(Tes Tulis)</label>
                <div class="col-lg-9">
                    {{-- <div class="switchery-list">
                        <input type="checkbox" name="is_free" class="js-switch-success" id="val-is_free" />
                        @error('is_free')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="has_tes_tulis" id="has_tes_tulis"
                            v-model="testu_enable">
                        <label class="custom-control-label" for="has_tes_tulis"></label>
                    </div>
                </div>
            </div>


            <div id="auto_hide" v-if="testu_enable === true">

                {{-- TT - Jumlah Sesi Per Hari --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jumlah Sesi Per Hari)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="testu_jumlah_sesi_perhari" id="testu_jumlah_sesi_perhari"
                                v-model="testu_jumlah_sesi_perhari" required />
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
                                v-model="testu_durasi_per_sesi" required />
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
                                v-model="testu_jumlah_peserta_persesi" required />
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
                                v-model="testu_tanggal_mulai" required />
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
                            <input type="time" name="testu_jam_mulai" id="testu_jam_mulai" v-model="testu_jam_mulai"
                                required />
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
                                    class="form-control" required>
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
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Jam)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="time" v-model="sesi.jam_sesi" name="testu_sesi_jam[]" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Lokasi)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="text" v-model="sesi.lokasi_sesi" name="testu_sesi_lokasi[]"
                                    class="form-control" required>
                                {{-- <input type="hidden" v-model="sesi.nama_sesi" name="testu_sesi_nama[]"
                                    class="form-control"> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 row mb-4" v-if="testu_data_sesi && testu_data_sesi.length > 0">
                    <div class="col-lg-3 col-form-label"></div>
                    <div class="col-lg-9">
                        <button class="btn btn-sm btn-primary" type="button" @click.prevent="tambahSesiTulis"><i
                                class="fa fa-plus"></i> Tambah Sesi</button>
                    </div>
                </div>

            </div>


            {{-- Tes Wawancara --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Tes Wawancara)</label>
                <div class="col-lg-9">
                    {{-- <div class="switchery-list">
                        <input type="checkbox" name="c" class="js-switch-success" id="val-is_free2" />
                        @error('wawancara')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="has_tes_wawancara"
                            id="has_tes_wawancara" v-model="teswa_enable">
                        <label class="custom-control-label" for="has_tes_wawancara"></label>
                    </div>
                </div>
            </div>


            <div id="auto_hide2" v-if="teswa_enable === true">

                {{-- TW - Jumlah Sesi Per Hari --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jumlah Sesi Per Hari)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="teswa_jumlah_sesi_perhari" id="teswa_jumlah_sesi_perhari"
                                v-model="teswa_jumlah_sesi_perhari" required />
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
                                v-model="teswa_durasi_per_sesi" required />
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
                                v-model="teswa_jumlah_peserta_persesi" required />
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
                                v-model="teswa_tanggal_mulai" required />
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

                {{-- Tes Wawancara Sesi --}}
                <div class="tes-wawancara tes-wawancara-row" v-for="(sesi, s_index) in teswa_data_sesi" :key="s_index">

                    <div class="text-h6" v-text="sesi.nama_sesi"></div>

                    {{-- Nama Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Nama Sesi)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="text" v-model="sesi.nama_sesi" name="teswa_sesi_nama[]"
                                    class="form-control" required>
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
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Jam)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="time" v-model="sesi.jam_sesi" name="teswa_sesi_jam[]" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Lokasi)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="text" v-model="sesi.lokasi_sesi" name="teswa_sesi_lokasi[]"
                                    class="form-control" required>
                                {{-- <input type="hidden" v-model="sesi.nama_sesi" name="teswa_sesi_nama[]"
                                    class="form-control"> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 row mb-4" v-if="teswa_data_sesi && teswa_data_sesi.length > 0">
                    <div class="col-lg-3 col-form-label"></div>
                    <div class="col-lg-9">
                        <button class="btn btn-sm btn-primary" type="button" @click.prevent="tambahSesiWawancara"><i
                                class="fa fa-plus"></i> Tambah Sesi</button>
                    </div>
                </div>

            </div>

            {{-- Pendaftaran Ulang --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">Pendaftaran Ulang</label>
                <div class="col-lg-9">
                    {{-- <div class="switchery-list">
                        <input type="checkbox" name="c" class="js-switch-success" id="val-is_free2" />
                        @error('wawancara')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="has_pendaftaran_ulang"
                            id="has_pendaftaran_ulang" v-model="pendul_enable">
                        <label class="custom-control-label" for="has_pendaftaran_ulang"></label>
                    </div>
                </div>
            </div>

            <div id="auto-hide3" v-if="pendul_enable">

                {{-- PENDUL - Jumlah Sesi Per Hari --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jumlah Sesi Per Hari)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="pendul_jumlah_sesi_perhari" id="pendul_jumlah_sesi_perhari"
                                v-model="pendul_jumlah_sesi_perhari" required />
                            @error('pendul_jumlah_sesi_perhari')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- PENDUL - Durasi Per Sesi --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Durasi Per Sesi) (Menit)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="pendul_durasi_per_sesi" id="pendul_durasi_per_sesi"
                                v-model="pendul_durasi_per_sesi" required />
                            @error('pendul_durasi_per_sesi')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- PENDUL - Jumlah Perserta Per Sesi --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jumlah Peserta Per Sesi)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="number" name="pendul_jumlah_peserta_persesi" id="pendul_jumlah_peserta_persesi"
                                v-model="pendul_jumlah_peserta_persesi" required />
                            @error('pendul_jumlah_peserta_persesi')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- PENDUL - Tanggal Mulai --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Tanggal Mulai)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="date" name="pendul_tanggal_mulai" id="pendul_tanggal_mulai"
                                v-model="pendul_tanggal_mulai" required />
                            @error('pendul_tanggal_mulai')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- PENDUL - Jam Mulai --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="">
                        @translate(Jam Mulai)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="time" name="pendul_jam_mulai" id="pendul_jam_mulai"
                                v-model="pendul_jam_mulai" />
                            @error('pendul_jam_mulai')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button class="btn btn-sm btn-primary mt-3" type="button"
                            @click.prevent="generateJadwalPendul">Generate Sesi</button>
                    </div>
                </div>

                {{-- Pendaftaran Ulang Sesi --}}
                <div class="pendaftaran-ulang pendaftaran-ulang-row" v-for="(sesi, s_index) in pendul_data_sesi"
                    :key="s_index">

                    <div class="text-h6" v-text="sesi.nama_sesi"></div>

                    {{-- Nama Sesi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Nama Sesi)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="text" v-model="sesi.nama_sesi" name="pendul_sesi_nama[]"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Tanggal)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="date" v-model="sesi.tanggal_sesi" name="pendul_sesi_tanggal[]"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Jam)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="time" v-model="sesi.jam_sesi" name="pendul_sesi_jam[]" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">
                            @translate(Lokasi)</label>
                        <div class="col-lg-9">
                            <div class="input-group mb-3">
                                <input type="text" v-model="sesi.lokasi_sesi" name="pendul_sesi_lokasi[]"
                                    class="form-control" required>
                                {{-- <input type="hidden" v-model="sesi.nama_sesi" name="teswa_sesi_nama[]"
                                    class="form-control"> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 row mb-4" v-if="pendul_data_sesi && pendul_data_sesi.length > 0">
                    <div class="col-lg-3 col-form-label"></div>
                    <div class="col-lg-9">
                        <button class="btn btn-sm btn-primary" type="button" @click.prevent="tambahSesiPendul"><i
                                class="fa fa-plus"></i> Tambah Sesi</button>
                    </div>
                </div>


            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    <strong>@translate(Tambahan :)</label></strong>
                <div class="col-lg-9">
                    <div class="switchery-list">

                    </div>
                </div>
            </div>
            {{-- Tes Tulis --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="need_dtks">
                    @translate(Perlu DTKS)</label>
                <div class="col-lg-9">
                    {{-- <div class="switchery-list">
                        <input type="checkbox" name="dtks" class="js-switch-success" id="dtks" />
                        @error('dtks')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="need_dtks" id="need_dtks">
                        <label class="custom-control-label" for="need_dtks"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="allow_disability">
                    @translate(Disabilitas)</label>
                <div class="col-lg-9">
                    {{-- <div class="switchery-list">
                        <input type="checkbox" name="difabel" class="js-switch-success" id="difabel" />
                        @error('difabel')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="allow_disability"
                            id="allow_disability">
                        <label class="custom-control-label" for="allow_disability"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                </label>
                <div class="col-lg-9">
                    <div class="switchery-list">
                    </div>
                </div>
            </div>
            <div class="field_wrapper">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-title">
                        @translate(Logbook) <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" required value="{{ old('logbook') }}"
                            class="form-control @error('logbook') is-invalid @enderror" id="val-logbook"
                            name="logbook[]" aria-required="true" autofocus>
                        @error('logbook')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-1"> <a class="btn btn-success" href="javascript:void(0);" id="add_button"
                            title="Add field">
                            <i class="la la-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="form-group row">
            <label class="col-lg-3 col-form-label"></label>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary">
                    @translate(Submit)</button>
            </div>
        </div>
        {{-- <div class="form-group row" style="display: none;">
            <label class="col-lg-3 col-form-label" for="val-title"></label>
            <div class="col-lg-8">
                <input type="text" required value="{{ old('logbook') }}"
                    class="form-control @error('logbook') is-invalid @enderror" id="val-logbook" name="logbook"
                    aria-required="true" autofocus>
                @error('logbook')
                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                @enderror
            </div>
            <div class="col-lg-1"><button class="btn btn-success add-more" type="button"><i
                        class="la la-trash"></i></button>
            </div>
        </div> --}}
</form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('#add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="form-group row"><label class="col-lg-3 col-form-label" for="val-title"></label>';
            fieldHTML=fieldHTML + '<div class="col-lg-8"><input type="text" required value="{{ old('logbook') }}" class="form-control @error('logbook') is-invalid @enderror" id="val-logbook" name="logbook[]" aria-required="true" autofocus> @error('logbook') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div>';
            fieldHTML=fieldHTML + '<div class="col-lg-1"><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="la la-trash"></i></a></div>';
            fieldHTML=fieldHTML + '</div>'; 
            var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
</script>

<!-- END:content -->
@endsection
@section('js-link')
@include('layouts.include.form.form_js')
@stop
@section('page-script')
<script type="text/javascript" src="{{ asset('assets/js/custom/course.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    // var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-success2'));
        // elems.forEach(function(html) {
        //     console.log(html)
        //     var switchery = new Switchery(html, { color: '#43d187' });
        // });
        Vue.createApp({
            data() {
                return {
                    title: 'Hello Vue!',
                    jumlah_peserta: 50,

                    // tes tulis
                    testu_enable: false,
                    testu_jumlah_sesi_perhari: 4,
                    testu_durasi_per_sesi: 30,
                    testu_jumlah_peserta_persesi: 10,
                    testu_tanggal_mulai: moment().format('YYYY-MM-DD'),
                    testu_jam_mulai: '09:00',
                    testu_data_sesi: [],

                    // tes wawancara
                    // jumlah_peserta_wawancara: 50,
                    teswa_enable: false,
                    teswa_jumlah_sesi_perhari: 4,
                    teswa_durasi_per_sesi: 30,
                    teswa_jumlah_peserta_persesi: 10,
                    teswa_tanggal_mulai: moment().format('YYYY-MM-DD'),
                    teswa_jam_mulai: '09:00',
                    teswa_data_sesi: [],

                    // pendaftaran ulang
                    pendul_enable: false,
                    pendul_jumlah_sesi_perhari: 4,
                    pendul_durasi_per_sesi: 30,
                    pendul_jumlah_peserta_persesi: 10,
                    pendul_tanggal_mulai: moment().format('YYYY-MM-DD'),
                    pendul_jam_mulai: '09:00',
                    pendul_data_sesi: [],
                }
            },
            mounted() {
                // elems.forEach(function(html) {
                //     console.log(html)
                //     var switchery = new Switchery(html, { color: '#43d187' });
                // });
            },
            watch: {
                // testu_enable: function(value) {
                //     console.log(value)
                //     if (value === true) {
                //         this.generateJadwalTulis()
                //     } else {
                //         this.testu_data_sesi = []
                //     }
                // },
                // teswa_enable: function(value) {
                //     console.log(value)
                //     if (value === true) {
                //         this.generateJadwalWawancara()
                //     } else {
                //         this.teswa_data_sesi = []
                //     }
                // }
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
                                jumlah_peserta: this.testu_jumlah_sesi_perhari * this
                                    .testu_jumlah_peserta_persesi,
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

                generateJadwalPendul() {

                    if (this.jumlah_peserta < 1) {
                        return alert('Jumlah Peserta wajib diisi!');
                    }

                    const jumlah_hari = Math.ceil(this.jumlah_peserta / (this.pendul_jumlah_sesi_perhari * this
                        .pendul_jumlah_peserta_persesi))
                    const jumlah_peserta_sisa = this.jumlah_peserta % (this.pendul_jumlah_sesi_perhari * this
                        .pendul_jumlah_peserta_persesi)

                    console.log('jumlah_hari', jumlah_hari)
                    console.log('jumlah_peserta_sisa', jumlah_peserta_sisa)

                    let hari = []
                    let last_index = jumlah_hari - 1
                    for (let i = 0; i < jumlah_hari; i++) {
                        if (i !== last_index && jumlah_peserta_sisa > 0) {
                            if (i == 0) {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.pendul_jumlah_sesi_perhari * this
                                        .pendul_jumlah_peserta_persesi,
                                    tanggal: moment(this.pendul_tanggal_mulai).add(0, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.pendul_jam_mulai
                                })
                            } else {
                                hari.push({
                                    nomor: i + 1,
                                    jumlah_peserta: this.pendul_jumlah_sesi_perhari * this
                                        .pendul_jumlah_peserta_persesi,
                                    tanggal: moment(this.pendul_tanggal_mulai).add(i, 'd').format(
                                        'YYYY-MM-DD'),
                                    jam_mulai: this.pendul_jam_mulai
                                })
                            }
                        } else if (jumlah_hari == 1) {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: this.pendul_jumlah_sesi_perhari * this
                                    .pendul_jumlah_peserta_persesi,
                                tanggal: moment(this.pendul_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.pendul_jam_mulai
                            })
                        } else {
                            hari.push({
                                nomor: i + 1,
                                jumlah_peserta: jumlah_peserta_sisa,
                                tanggal: moment(this.pendul_tanggal_mulai).add(i, 'd').format('YYYY-MM-DD'),
                                jam_mulai: this.pendul_jam_mulai
                            })
                        }
                    }
                    console.log('hari', hari)

                    let sesi = [],
                        nomor = 1;
                    for (let x = 0; x < hari.length; x++) {
                        const perhari = hari[x];
                        const sesi_per_hari = perhari.jumlah_peserta / this.pendul_jumlah_peserta_persesi
                        let durasi = 0;
                        for (let z = 0; z < sesi_per_hari; z++) {
                            let tanggal = perhari.tanggal + ' ' + perhari.jam_mulai
                            sesi.push({
                                nama_sesi: `Hari ${x+1} Sesi ${z+1}`,
                                tanggal_sesi: perhari.tanggal,
                                jam_sesi: moment(tanggal).add(durasi, 'm').format('HH:mm'),
                                lokasi_sesi: '-'
                            })
                            durasi += this.pendul_durasi_per_sesi
                        }
                    }

                    console.log('sesi', sesi)
                    this.pendul_data_sesi = sesi

                },

                tambahSesiTulis() {
                    this.testu_data_sesi.push({
                        nama_sesi: 'Sesi Baru',
                        tanggal_sesi: null,
                        jam_sesi: null,
                        lokasi_sesi: '-'
                    })
                },
                tambahSesiWawancara() {
                    this.teswa_data_sesi.push({
                        nama_sesi: 'Sesi Baru',
                        tanggal_sesi: null,
                        jam_sesi: null,
                        lokasi_sesi: '-'
                    })
                },
                tambahSesiPendul() {
                    this.pendul_data_sesi.push({
                        nama_sesi: 'Sesi Baru',
                        tanggal_sesi: null,
                        jam_sesi: null,
                        lokasi_sesi: '-'
                    })
                }

            }
        }).mount('#app')
</script>

@stop