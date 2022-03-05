@extends('frontend.app')
@section('content')
    <!-- ================================
                                                                          START BREADCRUMB AREA
                                                                      ================================= -->
    <section class="breadcrumb-area my-courses-bread">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content my-courses-bread-content">
                        <div class="section-heading">
                            <h2 class="section__title">@translate(Pelatihan saya)</h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                    <div class="my-courses-tab">
                        <div class="section-tab section-tab-2">
                            <ul class="nav nav-tabs" role="tablist" id="review">
                                <li role="presentation" class="padding-r-3">
                                    <a href="{{ route('my.courses') }}" class="active">
                                        @translate(Semua Pelatihan)
                                    </a>
                                </li>

                                <li role="presentation" class="padding-r-3">
                                    <a href="{{ route('my.wishlist') }}">
                                        @translate(Pelatihan Diminati)
                                    </a>
                                </li>
                                @if (env('SUBSCRIPTION_ACTIVE') == 'YES')
                                    <li role="presentation">
                                        <a href="{{ route('my.subscription') }}">
                                            @translate(Pelatihan Berlangganan)
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end breadcrumb-area -->
    <!-- ================================
                                                                            END BREADCRUMB AREA
                                                                        ================================= -->

    <!-- ================================
                                                                            START FLASH MESSAGE
                                                                        ================================= -->

    @if (Session::has('message'))
        <div class="alert alert-info text-center">{{ Session::get('message') }}</div>
    @endif

    <!-- ================================
                                                                          END FLASH MESSAGE
                                                                      ================================= -->

    <!-- ================================
                                                                               START MY COURSES
                                                                        ================================= -->
    <section class="my-courses-area padding-top-30px padding-bottom-90px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="my-course-content-wrap">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active show" id="#all-course">
                                <div class="my-course-content-body">
                                    <div class="my-course-container">
                                        @foreach ($enrolls as $item)
                                            <div class="row">
                                                <div class="col-lg-4 column-td-half">
                                                    <div class="card-item">
                                                        <div class="card-image">
                                                            <a href="{{ route('lesson_details', $item->enrollCourse->slug) }}"
                                                                class="card__img">
                                                                <img src="{{ filePath($item->enrollCourse->image) }}"
                                                                    alt="{{ $item->enrollCourse->title }}">
                                                            </a>
                                                        </div><!-- end card-image -->
                                                        <div class="card-content p-4">
                                                            <h3 class="card__title mt-0">
                                                                <a
                                                                    href="{{ route('course.single', $item->enrollCourse->slug) }}">{{ Str::limit($item->enrollCourse->title, 58) }}</a>
                                                            </h3>
                                                            <p class="card__author">
                                                                <a
                                                                    href="{{ route('single.instructor', $item->enrollCourse->slug) }}">{{ $item->enrollCourse->name }}</a>
                                                            </p>
                                                            <div
                                                                class="mb-3 d-flex justify-content-between align-items-center">
                                                                <span>Status Pelatihan :</span> <span
                                                                    class="badge badge-success">{{ $item->status }}</span>
                                                            </div>
                                                            {{-- <div class="course-complete-bar-2 mt-2">
                                                                <div class="progress-item mb-0">
                                                                    <p class="skillbar-title">@translate(Selesai):</p>
                                                                    <div class="skillbar-box mt-1">
                                                                        <div class="skillbar">
                                                                            <div class="skillbar-bar skillbar-bar-1"
                                                                                style="width: {{ \App\Http\Controllers\FrontendController::seenCourse($item->id, $item->enrollCourse->id) }}%;">
                                                                            </div>
                                                                        </div> <!-- End Skill Bar -->
                                                                    </div>
                                                                    <div class="skill-bar-percent">
                                                                        {{ \App\Http\Controllers\FrontendController::seenCourse($item->id, $item->enrollCourse->id) }}
                                                                        %
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            <!-- end course-complete-bar-2 -->
                                                            <div class="text-center mt-3">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <a href="{{ route('course.single', $item->enrollCourse->slug) }}"
                                                                            class="btn btn-success btn-block mt-2">@translate(Detail
                                                                            Pelatihan)</a>
                                                                    </div>
                                                                    {{-- <div class="col-md-6">
                                                                        <a href="{{ route('lesson_details', $item->enrollCourse->slug) }}"
                                                                            class="btn btn-success mt-2">@translate(Mulai
                                                                            Belajar)</a>
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div><!-- end card-content -->
                                                    </div><!-- end card-item -->
                                                </div><!-- end col-lg-4 -->
                                                <div class="col-lg-8">
                                                    <div class="card-item card">
                                                        <div class="card-body">
                                                            <h3 class="card__title">Tahapan Pelatihan</h3>
                                                            {!! $item->enrollCourse->tahapan_pelatihan !!}
                                                        </div>
                                                    </div>
                                                    <div class="card-item card">
                                                        <div class="card-body">
                                                            <h3 class="card__title">Status Pelatihan</h3>
                                                            <div class="overflow-auto timeline-wrapper">
                                                                <ul class="timeline pl-5">
                                                                    <li data-year="Pending"
                                                                        data-text="Pendaftaran sedang diverifikasi."
                                                                        class="done">
                                                                    </li>
                                                                    @if (in_array($item->status, ['Tes Tulis', 'Tes Wawancara', 'Gagal']))
                                                                        @if ($item->sesi_enroll_tes_tulis)
                                                                            <li data-year="Tes Tulis"
                                                                                data-text="{{ date('d M Y', strtotime($item->sesi_enroll_tes_tulis->tanggal_sesi)) }} - Pk. {{ $item->sesi_enroll_tes_tulis->jam_sesi }} di {{ $item->sesi_enroll_tes_tulis->lokasi_sesi }}"
                                                                                class="done">
                                                                            </li>
                                                                        @else
                                                                            <li data-year="Tes Tulis" data-text="-">
                                                                            </li>
                                                                        @endif
                                                                    @else
                                                                        <li data-year="Tes Tulis" data-text="-">
                                                                        </li>
                                                                    @endif
                                                                    @if (in_array($item->status, ['Tes Tulis', 'Tes Wawancara', 'Pendaftaran Ulang', 'Gagal']))
                                                                        @if ($item->sesi_enroll_tes_wawancara)
                                                                            <li data-year="Tes Wawancara"
                                                                                data-text="{{ date('d M Y', strtotime($item->sesi_enroll_tes_wawancara->tanggal_sesi)) }} - Pk. {{ $item->sesi_enroll_tes_wawancara->jam_sesi }} di {{ $item->sesi_enroll_tes_wawancara->lokasi_sesi }}"
                                                                                class="done">
                                                                            </li>
                                                                        @else
                                                                            <li data-year="Tes Wawancara" data-text="-">
                                                                            </li>
                                                                        @endif
                                                                    @else
                                                                        <li data-year="Tes Wawancara" data-text="-">
                                                                        </li>
                                                                    @endif
                                                                    @if ($item->status == 'Gagal')
                                                                        <li data-year="Gagal"
                                                                            data-text="Mohon maaf Anda belum dapat mengikut pelatihan."
                                                                            class="done">
                                                                        </li>
                                                                    @endif
                                                                    @if ($item->status != 'Gagal')
                                                                        @if (in_array($item->status, ['Tes Tulis', 'Tes Wawancara', 'Pendaftaran Ulang', 'Terdaftar']))
                                                                            @if ($item->sesi_enroll_pendaftaran_ulang)
                                                                                <li data-year="Pendaftaran Ulang"
                                                                                    data-text="{{ date('d M Y', strtotime($item->sesi_enroll_pendaftaran_ulang->tanggal_sesi)) }} - Pk. {{ $item->sesi_enroll_pendaftaran_ulang->jam_sesi }} di {{ $item->sesi_enroll_pendaftaran_ulang->lokasi_sesi }}"
                                                                                    class="done">
                                                                                </li>
                                                                            @else
                                                                                <li data-year="Pendaftaran Ulang"
                                                                                    data-text="-">
                                                                                </li>
                                                                            @endif
                                                                        @else
                                                                            <li data-year="Pendaftaran Ulang" data-text="-">
                                                                            </li>
                                                                        @endif
                                                                        @if (in_array($item->status, ['Tes Tulis', 'Tes Wawancara', 'Pendaftaran Ulang', 'Terdaftar', 'Lulus']))
                                                                            @if ($item->status == 'Terdaftar')
                                                                                <li data-year="Terdaftar" data-text=""
                                                                                    class="done">
                                                                                </li>
                                                                            @else
                                                                                <li data-year="Terdaftar" data-text="">
                                                                                </li>
                                                                            @endif
                                                                        @else
                                                                            <li data-year="Terdaftar" data-text="-"></li>
                                                                        @endif
                                                                        @if (in_array($item->status, ['Tes Tulis', 'Tes Wawancara', 'Pendaftaran Ulang', 'Terdaftar', 'Lulus']))
                                                                            @if ($item->status == 'Lulus')
                                                                                <li data-year="Lulus" data-text=""
                                                                                    class="done">
                                                                                </li>
                                                                            @else
                                                                                <li data-year="Lulus" data-text="">
                                                                                </li>
                                                                            @endif
                                                                        @else
                                                                            <li data-year="Lulus" data-text="-"></li>
                                                                        @endif
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="page-navigation-wrap mt-4 text-center">
                                        {{ $enrolls->links('frontend.include.paginate') }}
                                    </div><!-- end page-navigation-wrap -->
                                </div>
                            </div><!-- end tab-pane -->

                            <div role="tabpanel" class="tab-pane fade" id="#wishlist">
                                <div class="my-wishlist-wrap">
                                    <div class="my-wishlist-card-body padding-top-35px">
                                        <div class="row">

                                        </div><!-- end row -->
                                    </div>

                                </div><!-- end my-wishlist-wrap -->
                            </div><!-- end tab-pane -->

                        </div>
                    </div>
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end my-courses-area -->
    <!-- ================================
                                                                               START MY COURSES
                                                                        ================================= -->
@endsection

@push('styles')
    <style>
        .timeline-wrapper {
            outline: none;
            box-sizing: border-box;
            min-height: 250px;
            font-weight: 400;
            position: relative;
            display: flex;
            align-items: center;
            padding-right: 20px;
        }

        .timeline {
            width: 800px;
            height: 20px;
            list-style: none;
            text-align: justify;
            margin: 80px auto;
            background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(45%, rgba(255, 255, 255, 0)), color-stop(51%, rgba(191, 128, 11, 1)), color-stop(57%, rgba(255, 255, 255, 0)), color-stop(100%, rgba(255, 255, 255, 0)));
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0) 45%, rgba(191, 128, 11, 1) 51%, rgba(255, 255, 255, 0) 57%, rgba(255, 255, 255, 0) 100%);
        }

        .timeline:after {
            display: inline-block;
            content: "";
            width: 100%;
        }

        .timeline li {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #ffffff;
            text-align: center;
            line-height: 1.2;
            position: relative;
            border-radius: 50%;
            border: 1px solid #F2BB13;
        }

        .timeline li.done {
            background: #F2BB13;
        }

        .timeline li:before {
            display: inline-block;
            content: attr(data-year);
            font-size: 15px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 600;
        }

        .timeline li:nth-child(odd):before {
            top: -40px;
        }

        .timeline li:nth-child(even):before {
            bottom: -40px;
        }

        .timeline li.done:after {
            display: inline-block;
            content: attr(data-text);
            font-size: 12px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 10px;
            min-width: 100px;
        }

        .timeline li:nth-child(odd):after {
            bottom: 0;
            margin-bottom: -10px;
            transform: translate(-50%, 100%);
        }

        .timeline li:nth-child(even):after {
            top: 0;
            margin-top: -10px;
            transform: translate(-50%, -100%);
        }

    </style>
@endpush
