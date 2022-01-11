@extends('frontend.app')
@section('content')
  <!-- ================================
      START DASHBOARD AREA
  ================================= -->
  <section class="dashboard-area">

      @include('frontend.dashboard.sidebar')
      <div class="dashboard-content-wrap">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card-box-shared">
                        <div class="card-box-shared-title">
                            <h3 class="widget-title">@translate(Settings info)</h3>
                        </div>
                        <div class="card-box-shared-body">
                            <div class="section-tab section-tab-2">
                                <ul class="nav nav-tabs" role="tablist" id="review">
                                    <li role="presentation">
                                        <a href="#profile" role="tab" data-toggle="tab" class="active" aria-selected="true">
                                            @translate(Profile)
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
                                      <form method="post" action="{{ route('student.update', Auth::user()->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="user-form">
                                            <div class="user-profile-action-wrap mb-5">
                                                <h3 class="widget-title font-size-18 padding-bottom-40px">@translate(Profile Settings)</h3>
                                                <div class="user-profile-action d-flex align-items-center">
                                                    <div class="user-pro-img">
                                                        <img src="{{ filePath($student->image) }}" alt="{{ $student->name }}" class="img-fluid radius-round border">
                                                    </div>
                                                    <div class="upload-btn-box course-photo-btn">
                                                        <input type="hidden" name="oldImage" value="{{ $student->image }}">
                                                        <input type="file" name="image" value="">
                                                    </div>
                                                </div><!-- end user-profile-action -->
                                            </div><!-- end user-profile-action-wrap -->
                                            <div class="contact-form-action">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Full Name)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="text" name="name" value="{{ $student->name }}">
                                                                    <span class="la la-user input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->

                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Username)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="email" readonly name="email" value="{{ $student->email }}">
                                                                    <span class="la la-envelope input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Full Name)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="text" name="name" value="{{ $student->name }}">
                                                                    <span class="la la-user input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Provinces)</label>
                                                                <div class="form-group">
                                                                <select class="form-control provinsi-asal" name="province_origin">
                                                                    <option value="0">-- select provinces --</option>
                                                                    @foreach ($provinsi as $provinsis)
                                                                        <option value="{{ $provinsis['id']  }}">{{ $provinsis['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <!-- <select id="select_province" name="province_origin" data-placeholder="Select" class="custom-select w-100">
              
                                                                    @foreach ($provinsi as $provinsis)
                                                                        <option
                                                                            value="{{ $provinsis['id']}}">{{ $provinsis['name']}}</option>
                                                                    @endforeach
                                                                </select> -->
                                                                <span class="la la-map-marker input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Regencies)</label>
                                                                <div class="form-group">
                                                                <select class="form-control kota-asal" name="city_origin">
                                                                    <option value="">-- select regencies --</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Districts)</label>
                                                                <div class="form-group">
                                                                <select class="form-control kota-asal" name="kecamatan">
                                                                    <option value="">-- select districts --</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Villages)</label>
                                                                <div class="form-group">
                                                                <select class="form-control kota-asal" name="kelurahan">
                                                                    <option value="">-- select villages --</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 --><!-- end col-lg-6 -->
                                                        <div class="col-lg-12">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Adress)</label>
                                                                <div class="form-group">
                                                                    <textarea class="message-control form-control" name="about">{!! $student->about !!}</textarea>
                                                                    <span class="la la-pencil input-icon"></span>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-12 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Ktp)</label>
                                                                <div class="form-group">
                                                                    <input type="file" name="ktp" value="{{ $student->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Npwp)</label>
                                                                <div class="form-group">
                                                                    <input type="file" name="npwp" value="{{ $student->email }}">
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Ijazah)</label>
                                                                <div class="form-group">
                                                                    <input type="file" name="ijazah" value="{{ $student->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="input-box">
                                                                <label class="label-text">@translate(Skck)</label>
                                                                <div class="form-group">
                                                                    <input type="file" name="skck" value="{{ $student->email }}">
                                                                </div>
                                                            </div>
                                                        </div><!-- end col-lg-6 -->
                                                        <div class="col-lg-12">
                                                            <div class="btn-box">
                                                                <button class="theme-btn" type="submit">@translate(Save Changes)</button>
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
                                                <h3 class="widget-title font-size-18 padding-bottom-40px">@translate(Change Password)</h3>
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
                                                                <label class="label-text">@translate(New Password)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                  <input id="password" type="password"
                                                                         class="form-control @error('password') is-invalid @enderror"
                                                                         name="password" required autocomplete="new-password" placeholder="New password">

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
                                                                <label class="label-text">@translate(Confirm New Password)<span class="primary-color-2 ml-1">*</span></label>
                                                                <div class="form-group">
                                                                  <input id="password-confirm" type="password" class="form-control"
                                                                         name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
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
                                                                <button class="theme-btn" type="submit">@translate(Change password)</button>
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
@push('javascript-internal')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: 'https://emsifa.github.io/api-wilayah-indonesia/api/regencies/11'.json',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ name +'">'+ name +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>


@endpush    