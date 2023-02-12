@extends('frontend.app')
@section('content')
<!-- ================================
      START DASHBOARD AREA
  ================================= -->
<section class="dashboard-area">

    @include('frontend.dashboard.sidebar')

    <div class="dashboard-content-wrap">
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong> @foreach($errors->all() as $error)
                    {{ $error }}<br />
                    @endforeach</strong>
            </div>


        </div>
        @endif
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card-box-shared">
                        <div class="card-box-shared-title">
                            <h3 class="widget-title">@translate(Info Pengaturan )</h3>
                        </div>
                        <div class="card-box-shared-body">
                            <div class="section-tab section-tab-2">
                                <ul class="nav nav-tabs" role="tablist" id="review">
                                    <li role="presentation">
                                        <a href="#profile" role="tab" data-toggle="tab" class="active"
                                            aria-selected="true">
                                            @translate(Profil)
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#password" role="tab" data-toggle="tab" aria-selected="false">
                                            @translate(Password)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dashboard-tab-content mt-5">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active show" id="profile">
                                        <form method="post" action="{{ route('student.update', Auth::user()->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="user-form">
                                                <div class="user-profile-action-wrap mb-5">
                                                    <h3 class="widget-title font-size-18 padding-bottom-40px">
                                                        @translate(Profile Settings)</h3>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="user-profile-action d-flex align-items-center">
                                                                <div class="user-pro-img">
                                                                    <img src="{{ filePath($student->image) }}"
                                                                        alt="{{ $student->name }}"
                                                                        class="img-fluid radius-round border">
                                                                </div>
                                                                <div class="upload-btn-box course-photo-btn">
                                                                    <input type="hidden" name="oldImage"
                                                                        value="{{ $student->image }}">
                                                                    <input type="file" name="image" value="">
                                                                </div>
                                                            </div><!-- end user-profile-action -->
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6 contact-form-action">
                                                            <div class="input-box">
                                                                <label class="label-text">Tanggal Lahir<span
                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="date"
                                                                        name="tgl_lahir"
                                                                        value="{{ $student->tgl_lahir }}">
                                                                    <span class="la la-calendar input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                    </div>
                                                </div><!-- end user-profile-action-wrap -->
                                                <div class="contact-form-action">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Nama Lengkap)<span
                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="text" name="name"
                                                                        value="{{ $student->name }}">
                                                                    <span class="la la-user input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->

                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Username)<span
                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="email" readonly
                                                                        name="email" value="{{ $student->email }}">
                                                                    <span class="la la-envelope input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Nama Lengkap)<span
                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="text" name="name"
                                                                        value="{{ $student->name }}">
                                                                    <span class="la la-user input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Provinsi)</label>
                                                                <div class="form-group">
                                                                    <select class="form-control provinsi-asal"
                                                                        name="id_provinsi">
                                                                        @if (!empty($student->id_provinsi) &&
                                                                        !empty($student->nama_provinsi))
                                                                        <option value="{{ $student->id_provinsi }}"
                                                                            selected>{{ $student->nama_provinsi }}
                                                                        </option>
                                                                        @else
                                                                        <option value="">-- Pilih Provinsi --
                                                                        </option>
                                                                        @endif
                                                                        {{-- @foreach ($provinsi as $key => $prov)
                                                                        <option value="{{ $prov['id']  }}">{{
                                                                            $prov['nama'] }}</option>
                                                                        @endforeach --}}
                                                                    </select>
                                                                    <!-- <select id="select_province" name="id_provinsi" data-placeholder="Select" class="custom-select w-100">
              
                                                                    {{-- @foreach ($provinsi as $prov)
                                                                        <option
                                                                            value="{{ $prov['id']}}">{{ $prov['nama']}}</option>
                                                                    @endforeach --}}
                                                                </select> -->
                                                                    <span class="la la-map-marker input-icon"></span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="nama_provinsi"
                                                                value="{{$student->nama_provinsi}}">
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label
                                                                    class="label-text">@translate(Kabupaten/kota)</label>
                                                                <div class="form-group">
                                                                    <select class="form-control kota-asal"
                                                                        name="id_kota" {{ !empty($student->id_kota) &&
                                                                        !empty($student->nama_kota) ? 'disabled' : ''
                                                                        }}>
                                                                        @if (!empty($student->id_kota) &&
                                                                        !empty($student->nama_kota))
                                                                        <option value="{{ $student->id_kota }}"
                                                                            selected>{{ $student->nama_kota }}
                                                                        </option>
                                                                        @else
                                                                        <option value="">-- Pilih Kota/Kabupaten --
                                                                        </option>
                                                                        @endif
                                                                    </select>
                                                                    <span class="la la-map-marker input-icon"></span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="nama_kota"
                                                                value="{{$student->nama_kota}}">
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Kecamatan)</label>
                                                                <div class="form-group">
                                                                    <select class="form-control kecamatan-asal"
                                                                        name="id_kecamatan" {{
                                                                        !empty($student->id_kecamatan) &&
                                                                        !empty($student->nama_kecamatan) ? 'disabled' :
                                                                        '' }}>
                                                                        @if (!empty($student->id_kecamatan) &&
                                                                        !empty($student->nama_kecamatan))
                                                                        <option value="{{ $student->id_kecamatan }}"
                                                                            selected>{{ $student->nama_kecamatan }}
                                                                        </option>
                                                                        @else
                                                                        <option value="">-- Pilih Kecamatan --</option>
                                                                        @endif
                                                                    </select>
                                                                    <span class="la la-map-marker input-icon"></span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="nama_kecamatan"
                                                                value="{{$student->nama_kecamatan}}">
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Kelurahan)</label>
                                                                <div class="form-group">
                                                                    <select class="form-control kelurahan-asal"
                                                                        name="id_kelurahan" {{
                                                                        !empty($student->id_kelurahan) &&
                                                                        !empty($student->nama_kelurahan) ? 'disabled' :
                                                                        '' }}>
                                                                        @if (!empty($student->id_kelurahan) &&
                                                                        !empty($student->nama_kelurahan))
                                                                        <option value="{{ $student->id_kelurahan }}"
                                                                            selected>{{ $student->nama_kelurahan }}
                                                                        </option>
                                                                        @else
                                                                        <option value="">-- Pilih Kelurahan --</option>
                                                                        @endif
                                                                    </select>
                                                                    <span class="la la-map-marker input-icon"></span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="nama_kelurahan"
                                                                value="{{$student->nama_kelurahan}}">
                                                        </div><!-- end col-lg-6 -->
                                                        <!-- end col-lg-6 -->
                                                        <div class="col-lg-12">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Alamat)</label>
                                                                <div class="form-group">
                                                                    <textarea class="message-control form-control"
                                                                        name="about">{!! $student->about !!}</textarea>
                                                                    <span class="la la-pencil input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-12 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Apakah Anda
                                                                    Difabel)</label>
                                                                <div class="form-group">
                                                                    <div class="switchery-list">
                                                                        <input type="checkbox" name="is_disable"
                                                                            class="js-switch-success"
                                                                            {{$student->is_disable ? 'checked' : ''}} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="auto_hide3">
                                                            <div class="col-lg-6 col-sm-6">
                                                                {{-- <div class="input-box">
                                                                    <label class="label-text"></label>
                                                                    <div class="form-group">
                                                                        <input type="text" name="npwp" value="">
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Nomor DTKS)</label>
                                                                <i class="la la-info-circle" data-toggle="tooltip"
                                                                    data-placement="right"
                                                                    title="Masukkan Nomor DTKS yang ada di kartu"></i>

                                                                <div class="form-group">
                                                                    <input class="form-control" type="number"
                                                                        name="dtks" value="{{ $student->dtks }}">
                                                                    <span class="la la-file input-icon"></span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text"></label>
                                                                <div class="form-group">

                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-12">
                                                            <div class="btn-box">
                                                                <button class="theme-btn"
                                                                    type="submit">@translate(Simpan Perubahan)</button>
                                                            </div>
                                                        </div><!-- end col-lg-12 -->
                                                    </div><!-- end row -->
                                        </form>
                                    </div>
                                </div>
                            </div><!-- end tab-pane-->
                            <div role="tabpanel" class="tab-pane fade" id="password">
                                <div class="user-form padding-bottom-60px">
                                    <div class="user-profile-action-wrap">
                                        <h3 class="widget-title font-size-18 padding-bottom-40px">@translate(Ubah
                                            Password)</h3>
                                    </div><!-- end user-profile-action-wrap -->
                                    <div class="contact-form-action">
                                        <form method="POST" action="{{  route('student.reset_password')}}">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" name="user_id" value="{{ $student->id }}">
                                                <!-- <div class="col-lg-4 col-sm-4">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(E-Mail Address)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                  <input id="email" type="email"
                                                                         class="form-control @error('email') is-invalid @enderror"
                                                                         name="email" value="{{ $email ?? old('email') }}" required
                                                                         autocomplete="email" autofocus placeholder="Email address">

                                                                    <span class="la la-lock input-icon"></span>

                                                                    @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                        </div>end col-lg-4 -->
                                                <div class="col-lg-4 col-sm-4">
                                                    <div class="input-box">
                                                        <label class="label-text">@translate(Password Baru)<span
                                                                class="primary-color-2 ml-1">*</span></label>
                                                        <div class="form-group">
                                                            <input id="password" type="password"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                name="password" required autocomplete="new-password"
                                                                placeholder="Password Baru"
                                                                oninput="setPasswordConfirmValidity()">

                                                            <span class="la la-lock input-icon"></span>


                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div><!-- end col-lg-4 -->
                                                <div class="col-lg-4 col-sm-4">
                                                    <div class="input-box">
                                                        <label class="label-text">@translate(Konfirmasi Password
                                                            Baru)<span class="primary-color-2 ml-1">*</span></label>
                                                        <div class="form-group">
                                                            <input id="password-confirm" type="password"
                                                                class="form-control" name="password_confirmation"
                                                                required autocomplete="new-password"
                                                                placeholder="Konfirmasi password"
                                                                oninput="setPasswordConfirmValidity()">
                                                            <span class="la la-lock input-icon"></span>

                                                            @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div><!-- end col-lg-4 -->
                                                <div class="col-lg-12">
                                                    <div class="btn-box">
                                                        <button class="theme-btn" type="submit">@translate(Ubah
                                                            Password)</button>
                                                    </div>
                                                </div><!-- end col-lg-12 -->
                                            </div><!-- end row -->
                                        </form>
                                    </div>
                                </div>
                                <div class="section-block"></div>
                                <!--  -->
                            </div><!-- end tab-pane-->

                        </div><!-- end tab-content -->
                    </div><!-- end dashboard-tab-content -->
                </div>
            </div><!-- end card-box-shared -->
        </div><!-- end col-lg-12 -->
    </div><!-- end row -->
    @include('frontend.dashboard.footer')

    </div><!-- end container-fluid -->
    </div><!-- end dashboard-content-wrap -->

</section><!-- end dashboard-area -->
<!-- ================================
      END DASHBOARD AREA
  ================================= -->
@endsection
@push('script')
{{-- <script type="text/javascript" src="{{ asset('assets/js/custom/course.js') }}"></script> --}}
<script type="text/javascript">
    var base_url = "http://www.emsifa.com/api-wilayah-indonesia";

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
   
    $.ajax({
        url: base_url + '/api/provinces.json',
        type: "GET",
        dataType: "json",
        success:function(response) {

            
          
            if (!$('select[name="id_provinsi"]').val()) {
                $('select[name="id_provinsi"]').empty();  
                $('select[name="id_provinsi"]').append('<option value="">-- Pilih Provinsi --</option>');
            } 
            $.each(response, function(key, value) {
                console.log(key,value)
                $('select[name="id_provinsi"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });


        }
    });

    $(document).ready(function() {

        $('select[name="id_provinsi"]').on('change', function() {
            var provinsiID = $(this).val();
            var provinsiName = $("option:selected", this).text()
            $('[name=nama_provinsi]').val(provinsiName)

            //reset other selection
            $('select[name="id_kota"]').empty();
            $('select[name="id_kota"]').prop('disabled', false);
            $('select[name="nama_kota"]').empty();

            $('select[name="id_kecamatan"]').empty();
            $('select[name="nama_kecamatan"]').empty();
            $('select[name="id_kecamatan"]').prop('disabled', false);
            
            $('select[name="id_kelurahan"]').empty();
            $('select[name="id_kelurahan"]').prop('disabled', false);
            $('select[name="nama_kelurahan"]').empty();

            if(provinsiID) {
                $.ajax({
                    url: base_url + '/api/regencies/' + provinsiID + '.json',
                    type: "GET",
                    dataType: "json",
                    success:function(response) {

                        
                        
                        $('select[name="id_kota"]').empty();
                        $('select[name="id_kota"]').append('<option value="">-- Pilih Kota/Kabupaten --</option>');
                        $.each(response, function(key, value) {
                            $('select[name="id_kota"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="id_kota"]').empty();
            }
        });

        $('select[name="id_kota"]').on('change', function() {
            var kotaID = $(this).val();
            var kotaName = $("option:selected", this).text()
            $('[name=nama_kota]').val(kotaName)

            //reset other selection
            $('select[name="id_kecamatan"]').empty();
            $('select[name="id_kecamatan"]').prop('disabled', false);
            $('select[name="nama_kecamatan"]').empty();
            
            $('select[name="id_kelurahan"]').empty();
            $('select[name="id_kelurahan"]').prop('disabled', false);
            $('select[name="nama_kelurahan"]').empty();
            

            if(kotaID) {
                $.ajax({
                    url: base_url + '/api/districts/' + kotaID + '.json',
                    type: "GET",
                    dataType: "json",
                    success:function(response) {

                        
                        
                        $('select[name="id_kecamatan"]').empty();
                        $('select[name="id_kecamatan"]').append('<option value="">-- Pilih Kecamatan --</option>');
                        $.each(response, function(key, value) {
                            $('select[name="id_kecamatan"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="id_kecamatan"]').empty();
            }
        });

        $('select[name="id_kecamatan"]').on('change', function() {
            var kecamatanID = $(this).val();
            var kecamatanName = $("option:selected", this).text()
            $('[name=nama_kecamatan]').val(kecamatanName)

            //reset other selection
            $('select[name="id_kelurahan"]').empty();
            $('select[name="id_kelurahan"]').prop('disabled', false);
            $('select[name="nama_kelurahan"]').empty();

            if(kecamatanID) {
                $.ajax({
                    url: base_url + '/api/villages/' + kecamatanID + '.json',
                    type: "GET",
                    dataType: "json",
                    success:function(response) {

                        
                        
                        $('select[name="id_kelurahan"]').empty();
                        $('select[name="id_kelurahan"]').append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(response, function(key, value) {
                            $('select[name="id_kelurahan"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="id_kelurahan"]').empty();
            }
        });

        $('select[name="id_kelurahan"]').on('change', function() {
            var kelurahanID = $(this).val();
            var kelurahanName = $("option:selected", this).text()
            $('[name=nama_kelurahan]').val(kelurahanName)
        });

    });
</script>


@endpush