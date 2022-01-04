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
                                        <a >
                                             @translate(Password)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dashboard-tab-content mt-5">
                                <div class="tab-content">
                                    <div >
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@endpush    