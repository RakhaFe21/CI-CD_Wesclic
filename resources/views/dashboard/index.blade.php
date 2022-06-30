@extends('layouts.master')
@section('title', 'Dashboard')
@section('parentPageTitle', 'index')
@section('content')
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12 col-xl-8">
            <!-- Start row -->
            <div class="row">
                <!-- Start col Pendapatan
                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ formatPrice($this_earning) }}</h4>
                                    <p class="font-14 mb-0">@translate(Pendapatan Bulan Ini)</p>
                                </div>
                                <div class="col-5 text-right">
                                    <div id="apex-area3-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ formatPrice($prev_earning) }}</h4>
                                    <p class="font-14 mb-0">@translate(Pendapatan Bulan Lalu)</p>
                                </div>
                                <div class="col-5 text-right">
                                    <div id="apex-area2-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ formatPrice($total_earning) }}</h4>
                                    <p class="font-14 mb-0">@translate(Total) <br> @translate(Total
                                        Pendapatan) </p>
                                </div>
                                <div class="col-5 text-right">
                                    <div id="apex-area1-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                End col -->
                <div class="col-lg-12 col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h5 class="card-title mb-0">@translate(Status)</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body crm-tab-widget">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-5 p-0">
                                    <div class="nav flex-column nav-pills" id="v-pills-ticket-tab" role="tablist"
                                        aria-orientation="vertical">
                                        @if (auth()->user()->user_type != 'Executive')
                                        <a class="nav-link active" id="v-pills-support-tab" data-toggle="pill"
                                        href="#v-pills-support" role="tab" aria-controls="v-pills-support"
                                        aria-selected="true"><i class="feather icon-circle font-12 mr-1">
                                        </i>@translate(Pelatihan)<span
                                            class="float-right font-14 text-muted">{{ $total_course }}</span></a>
                                        <a class="nav-link" id="v-pills-sales-tab" data-toggle="pill"
                                            href="#v-pills-sales" role="tab" aria-controls="v-pills-sales"
                                            aria-selected="false">
                                            <i class="feather icon-circle font-12 mr-1"></i>@translate(Pendaftaran)<span
                                                class="float-right font-14 text-muted">{{ $total_enrollments }}</span></a>
                                        <a class="nav-link" id="v-pills-product-tab" data-toggle="pill"
                                            href="#v-pills-product" role="tab" aria-controls="v-pills-product"
                                            aria-selected="false">
                                            <i class="feather icon-circle font-12 mr-1"></i>@translate(Dinas)<span
                                                class="float-right font-14 text-muted">{{ $total_instructor }}</span></a>
                                        <a class="nav-link" id="v-pills-hiring-tab" data-toggle="pill"
                                            href="#v-pills-hiring" role="tab" aria-controls="v-pills-hiring"
                                            aria-selected="false">
                                            <i class="feather icon-circle font-12 mr-1"></i>@translate(Siswa)<span
                                                class="float-right font-14 text-muted">{{ $total_students }}</span></a>
                                        @else
                                            <a class="nav-link active" id="v-pills-support-tab" 
                                                href="{{ route('course.index') }}" role="tab" aria-controls="v-pills-support"
                                                aria-selected="true"><i class="feather icon-circle font-12 mr-1"></i>@translate(Pelatihan)<span
                                                    class="float-right font-14 text-muted">{{ $total_course }}</span></a>
                                            <a class="nav-link" id="v-pills-sales-tab"
                                                href="{{ route('peserta.index') }}" role="tab" aria-controls="v-pills-sales"
                                                aria-selected="false">
                                                <i class="feather icon-circle font-12 mr-1"></i>@translate(Pendaftaran)<span
                                                    class="float-right font-14 text-muted">{{ $total_enrollments }}</span></a>
                                            <a class="nav-link" id="v-pills-product-tab"
                                                href="{{ route('instructors.index') }}" role="tab" aria-controls="v-pills-product"
                                                aria-selected="false">
                                                <i class="feather icon-circle font-12 mr-1"></i>@translate(Dinas)<span
                                                    class="float-right font-14 text-muted">{{ $total_instructor }}</span></a>
                                            <a class="nav-link" id="v-pills-hiring-tab"
                                                href="{{ route('students.index') }}" role="tab" aria-controls="v-pills-hiring"
                                                aria-selected="false">
                                                <i class="feather icon-circle font-12 mr-1"></i>@translate(Siswa)<span
                                                    class="float-right font-14 text-muted">{{ $total_students }}</span></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-sm-7 p-0">
                                    <div class="tab-content" id="v-pills-ticket-tabContent">
                                        {{-- <div class="tab-pane fade show active" id="v-pills-support" role="tabpanel"
                                            aria-labelledby="v-pills-support-tab">
                                            <div id="apex-operation-course-chart"></div>
                                           
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-sales" role="tabpanel"
                                            aria-labelledby="v-pills-sales-tab">
                                            <div id="apex-operation-enrollment-chart"></div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-product" role="tabpanel"
                                            aria-labelledby="v-pills-product-tab">
                                            <div id="apex-operation-instructor-chart"></div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-hiring" role="tabpanel"
                                            aria-labelledby="v-pills-hiring-tab">
                                            <div id="apex-operation-student-chart"></div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-12 col-sm-5 p-0 mb-4">
                                    <form id="searchForm" class="form-inline">
                                        <div class="form-group ml-3">
                                            <input type="text" class="form-control" placeholder="cari tanggal pelatihan..." name="search" id="search" autocomplete="off"/>
                                        </div>
                                        <div class="form-group ml-3">
                                            <button type="submit" class="btn btn-primary">oke</button>
                                        </div>
                                    </form>
                                </div>
                                <br/>
                                {{-- <div class="row justify-content-center mb-4">
                                    <h6>Grafik Pelatihan</h6>
                                    <canvas id="chartPelatihanSearch" class="chartjs" width="undefined" height="undefined"></canvas>
                                    <div id="countData"></div>
                                </div> --}}
                                <div class="row justify-content-center mb-4">
                                    <h6>Grafik Pelatihan pada bulan {{$monthName}}</h6>
                                    <canvas id="chartPelatihan" class="chartjs" width="undefined" height="undefined"></canvas>
                                    {{-- <div id="df"></div> --}}
                                </div>
                                <br/>
                                <div class="row justify-content-center mb-4">
                                    <h6>Grafik Pendaftaran pada bulan {{$monthName}}</h6>
                                    <canvas id="chartPendaftaran" class="chartjs" width="undefined" height="undefined"></canvas>
                                </div>
                                <br/>
                                <div class="row justify-content-center mb-4">
                                    <h6>Grafik Dinas pada bulan {{$monthName}}</h6>
                                    <canvas id="chartDinas" class="chartjs" width="undefined" height="undefined"></canvas>
                                </div>
                                <br/>
                                <div class="row justify-content-center mb-4">
                                    <h6>Grafik Siswa pada bulan {{$monthName}}</h6>
                                    <canvas id="chartSiswa" class="chartjs" width="undefined" height="undefined"></canvas>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
        </div>

        @if (auth()->user()->user_type != 'Executive')
            <div class="col-lg-12 col-xl-4 mb-2">
                <div class="card p-2and5">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0">@translate(Dinas Wonosobo)</h5>
                            </div>
                        </div>
                    </div>
                    <div class="user-slider">
                        @forelse($top_instructor as $item)
                            <div class="user-slider-item">
                                <div class="card-body text-center">
                                    <div class="m-4">
                                        <img src="{{ filePath($item->image) }}" class="img-center rounded-circle avatar-xl">
                                    </div>
                                    <a href="{{ route('instructors.show', $item->user_id) }}">
                                        <h5>{{ $item->name }}</h5>
                                        <p>{{ $item->email }}</p>
                                        <p><span class="badge badge-primary-inverse">@translate(Details)</span></p>
                                    </a>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            @php
                                                $total_student = 0;
                                            @endphp
                                            @foreach (\App\Model\Course::where('user_id', $item->user_id)->get() as $c)
                                                <input type="hidden"
                                                    value="{{ $total_student += App\Model\Enrollment::where('course_id', $c->id)->count() }}" />
                                            @endforeach
                                            <h4>{{ \App\Model\Course::where('user_id', $item->user_id)->count() }}</h4>
                                            <p class="my-2">@translate(Pelatihan)</p>
                                        </div>
                                        <div class="col-6">
                                            <h4>{{ $total_student }}</h4>
                                            <p class="my-2">@translate(Siswa)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h3 class="text-center mt-3">@translate(Tidak ada dinas terkait)</h3>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
        <!-- End col -->
    </div>
    <!-- End row -->

    <!-- Pendapatan Tahun
    <div class="card m-b-30">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-9">
                    <h5 class="card-title mb-0">@translate(Pendapatan Tahun Ini)</h5>
                </div>
            </div>
        </div>
        <div class="card-body pl-0 py-0">
            <div id="apexs-bar-chart"></div>
        </div>
    </div>
     -->
@endsection

@section('page-script')
    <script>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $( "#search" ).datepicker({
         locale:'id',
         dateFormat: 'yy-mm-dd'
       });

        // $(document).on('submit', '#searchForm', function(event){  
        //     event.preventDefault();  
        //     var search_date = $('#search').val(); 
            
        //     $.ajax({
        //         url: "{{ route('dashboard.search') }}",
        //         cache: false,  
        //         method:'POST',  
        //         data: {'search': search_date},
        //         success: function(data){
        //             $('#countData').html(data);
        //             var pelatihan_search = document.getElementById("chartPelatihanSearch").getContext('2d');
        //             var myChart = new Chart(pelatihan_search, {
        //                 type: 'radar',
        //                 data: {
        //                     datasets: [{
        //                         label: 'Total Pelatihan : ' + data,
        //                         backgroundColor: '#ffc200',
        //                         borderColor: '#ffc200',
        //                         data: data
        //                     }],
        //                     options: {
        //                         animation: {
        //                             onProgress: function(animation) {
        //                                 progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
        //                             }
        //                         }
        //                     }
        //                 },
        //             });   
        //         },
        //         error:function (xhr) {
        //             console.log(xhr.responseText);
        //         }
        //     })
        // }); 

        var pelatihan = document.getElementById("chartPelatihan").getContext('2d');
        var myChart = new Chart(pelatihan, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($label); ?>,
                datasets: [{
                    label: 'Total Pelatihan : ' + <?php echo json_encode($total_course); ?>,
                    backgroundColor: '#FFC200',
                    borderColor: '#FFC200',
                    data: <?php echo json_encode($jumlah_pelatihan); ?>
                }],
                options: {
                    animation: {
                        onProgress: function(animation) {
                            progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                        }
                    }
                }
            },
        });

        var pendaftaran = document.getElementById("chartPendaftaran").getContext('2d');
        var myChart = new Chart(pendaftaran, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($label); ?>,
                datasets: [{
                    label: 'Total Pendaftaran : ' + <?php echo json_encode($total_enrollments); ?>,
                    backgroundColor: '#FFBC51',
                    borderColor: '#FFBC51',
                    data: <?php echo json_encode($jumlah_pendaftaran); ?>
                }],
                options: {
                    animation: {
                        onProgress: function(animation) {
                            progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                        }
                    }
                }
            },
        });

        var dinas = document.getElementById("chartDinas").getContext('2d');
        var myChart = new Chart(dinas, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($label); ?>,
                datasets: [{
                    label: 'Total Dinas : ' + <?php echo json_encode($total_instructor); ?>,
                    color: '#4E4637',
                    backgroundColor: '#FFBB84',
                    borderColor: '#FFBB84',
                    borderRadius: 3,
                    font: {
                        size: 18,
                    },
                    data: <?php echo json_encode($jumlah_dinas); ?>
                }],
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    }
                }
            },
        });

        var siswa = document.getElementById("chartSiswa").getContext('2d');
        var myChart = new Chart(siswa, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($label); ?>,
                datasets: [{
                    label: 'Total Siswa : ' + <?php echo json_encode($total_students); ?>,
                    backgroundColor: '#FFC1B2',
                    borderColor: '#FFC1B2',
                    data: <?php echo json_encode($jumlah_siswa); ?>
                }],
                options: {
                    scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                    }
                }
            },
        });
    </script>
@endsection
