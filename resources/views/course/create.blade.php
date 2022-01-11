@extends('layouts.master')
@section('title','Course Create')
@section('parentPageTitle', 'Course')
@section('css-link')
@include('layouts.include.form.form_css')
@stop
@section('page-style')
@stop
@section('content')
<!-- BEGIN:content -->
<div class="card m-b-30">
    <h4 class="card-header">@translate(Tambah pelatihan baru)</h4>
    <div class="card-body mx-3">
        <form action="{{ route('course.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
           
            {{-- Course Title --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-title">
                    @translate(Nama Pelatihan) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" required
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           id="val-title" name="title" placeholder="@translate(Enter Course Title)" aria-required="true" autofocus>
                      @error('title') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Slug --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-slug">
                    @translate(Slug) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text"
                          required value="{{ old('slug') }}"
                           class="form-control @error('slug') is-invalid @enderror"
                           id="val-slug" name="slug" aria-required="true">
                    <span id="error_email"></span>
                    @error('slug') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-suggestions">
                    @translate(Description)</label>
                <div class="col-lg-9">
                    <textarea required="required" class="form-control summernote @error('short_description') is-invalid @enderror" name="short_description" rows="5" aria-required="true">{!! old('short_description') !!}</textarea>
                      @error('short_description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Course Thumbnail --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-img">
                    @translate(Course Thumbnail) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="hidden" required value="{{ old('image') }}" class="form-control course_image @error('image') is-invalid @enderror" id="val-img" name="image">
                    <img class="w-50 course_thumb_preview rounded shadow-sm d-none" src="" alt="#Course thumbnail">
                    @error('image') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                      <input type="hidden" name="course_thumb_url" class="course_thumb_url" value="">
                    <br>

                      @if (MediaActive())
                       {{-- media --}}
                      <a href="javascript:void()" onclick="openNav('{{ route('media.slide') }}', 'thumbnail')" class="btn btn-primary media-btn mt-2 p-2">Upload From Media <i class="fa fa-cloud-upload ml-2" aria-hidden="true"></i> </a>
                      @endif
                </div>
            </div>

            {{-- Category --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-category_id">
                    @translate(Category) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select class="form-control lang @error('category_id') is-invalid @enderror" id="val-category_id" name="category_id" required>
                        <option value="" class="mb-2">
                            @translate(Please Category)</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('category_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>

            {{-- tahapan & jadwal seleksi --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-suggestions">
                    @translate(tahapan & jadwal seleksi)</label>
                <div class="col-lg-9">
                    <textarea required="required" class="form-control summernote @error('big_description') is-invalid @enderror" name="big_description" rows="5">{{ old('big_description') }}</textarea>
                      @error('big_description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- tahapan pelatihan --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-suggestions">
                    @translate(tahapan pelatihan)</label>
                <div class="col-lg-9">
                    <textarea required="required" class="form-control summernote @error('tahapan_pelatihan') is-invalid @enderror" name="tahapan_pelatihan" rows="5">{{ old('tahapan_pelatihan') }}</textarea>
                      @error('tahapan_pelatihan') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Type pelatihan --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-provider">
                    @translate(Type pelatihan) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select  class="form-control lang @error('level') is-invalid @enderror" id="val-provider" name="level" required>
                        <option value="">
                            @translate(Select Level)</option>
                        <option value="Terbuka">
                            @translate(Terbuka)</option>
                        <option value="Tertutup">
                            @translate(Tertutup)</option>
                    </select>
                </div>
                @error('level') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>

            <!-- {{-- Overview URL --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-website">
                    @translate(Overview URL) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="url"  value="{{ old('overview_url') }}" class="form-control @error('overview_url') is-invalid @enderror" id="val-website" name="overview_url" placeholder="Overview URL" aria-required="true">
                      @error('overview_url') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Provider --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-provider">
                    @translate(Provider) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select class="form-control lang @error('provider') is-invalid @enderror" id="val-provider" name="provider" >
                        <option value="">
                            @translate(Select Provider)</option>
                        <option value="Youtube">
                            @translate(Youtube)</option>
                        <option value="Vimeo">
                            @translate(Vimeo)</option>
                        <option value="HTML5">
                            @translate(HTML5)</option>
                    </select>
                </div>
                @error('provider') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>

            {{-- Requirements --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-requirement">
                    @translate(Requirements) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="bootstrap-tagsinput">
                        <input type="text"  class="@error('requirement') is-invalid @enderror" placeholder="@translate(Enter Requirements)" id="val-requirement" name="requirement" data-role="tagsinput">
                          @error('requirement') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>
            </div>

            {{-- Outcome --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-outcome">
                    @translate(Outcome) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="bootstrap-tagsinput">
                        <input type="text"  class="@error('outcome') is-invalid @enderror" placeholder="@translate(Enter Outcome)"  id="val-outcome" name="outcome" data-role="tagsinput">
                          @error('outcome') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>
            </div>

            {{-- Tags --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-tag">
                    @translate(Tags) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="bootstrap-tagsinput">
                        <input type="text"  class="@error('tag') is-invalid @enderror" placeholder="@translate(Enter Tags)"  id="val-tag" name="tag" data-role="tagsinput">
                          @error('tag') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>
            </div> -->
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
                        <input required type="date" value="{{ old('price') }}" name="mulai" class="form-control @error('price') is-invalid @enderror">
                            @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">
                    @translate(Berakhir)</label>
                <div class="col-lg-9">
                    <div class="input-group mb-3">
                        <input required type="date" value="{{ old('price') }}" name="berakhir" class="form-control @error('price') is-invalid @enderror">
                            @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
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
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Tes Tulis)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="is_free" class="js-switch-success" id="val-is_free"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>


            <div id="auto_hide">
                {{-- Tanggal --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Tanggal)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                           <input type="date" value="{{ old('price') }}" name="tanggaltulis" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Jam --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Jam)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input type="time" value="{{ old('price') }}" name="jamtulis" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Lokasi)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input type="text" value="{{ old('price') }}" name="lokasitulis" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>
<!-- 
                {{-- Discount --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-is_discount">
                        @translate(Discount?)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="checkbox" name="is_discount" class="js-switch-success" id="val-is_discount"/>
                            @error('is_discount') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                        @error('is_discount') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>

                {{-- Discount Price --}}
                <div class="form-group" id="discount_price">
                  <div class="row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Price With Discount?)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" min="0" value="{{ old('discount_price') }}"
                                   name="discount_price"
                                   class="form-control @error('discount_price') is-invalid @enderror">
                              @error('discount_price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                  </div>
                </div> -->

            </div>
            {{-- Tes Wawancara --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Tes Wawancara)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="wawancara" class="js-switch-success" id="val-is_free2"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>


            <div id="auto_hide2">
                {{-- Tanggal --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Tanggal)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                           <input type="date" value="{{ old('price') }}" name="tanggalwawancara" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Jam --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Jam)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input type="time" value="{{ old('price') }}" name="jamwawancara" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Lokasi)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <input type="text" value="{{ old('price') }}" name="lokasiwawancara" class="form-control @error('price') is-invalid @enderror">
                              @error('price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                </div>
<!-- 
                {{-- Discount --}}
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="val-is_discount">
                        @translate(Discount?)</label>
                    <div class="col-lg-9">
                        <div class="switchery-list">
                            <input type="checkbox" name="is_discount" class="js-switch-success" id="val-is_discount"/>
                            @error('is_discount') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                        @error('is_discount') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>

                {{-- Discount Price --}}
                <div class="form-group" id="discount_price">
                  <div class="row">
                    <label class="col-lg-3 col-form-label">
                        @translate(Price With Discount?)</label>
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" min="0" value="{{ old('discount_price') }}"
                                   name="discount_price"
                                   class="form-control @error('discount_price') is-invalid @enderror">
                              @error('discount_price') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                    </div>
                  </div>
                </div> -->

            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    <strong>@translate(Persyaratan Dokumen :)</label></strong>
                <div class="col-lg-9">
                  <div class="switchery-list">
                 
                  </div>
                </div>
            </div>
            {{-- Tes Tulis --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(KTP)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="ktp" class="js-switch-success" id="ktp"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Npwp)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="npwp" class="js-switch-success" id="npwp"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Ijazah)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="ktp" class="js-switch-success" id="ktp"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="">
                    @translate(Skck)</label>
                <div class="col-lg-9">
                  <div class="switchery-list">
                      <input type="checkbox"   name="npwp" class="js-switch-success" id="npwp"/>
                      @error('is_free') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                  </div>
                </div>
            </div>
            <div class="field_wrapper">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-title">
                    @translate(Logbook) <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="text" required
                           value="{{ old('logbook') }}"
                           class="form-control @error('logbook') is-invalid @enderror"
                           id="val-logbook" name="logbook[]" aria-required="true" autofocus> 
                      @error('logbook') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div><div class="col-lg-1"> <a class="btn btn-success" href="javascript:void(0);" id="add_button" title="Add field">
              <i class="la la-plus"></i></a>
            </div>
            </div>
            </div>
        </div>
            <!-- {{-- language --}}

            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="language">
                    @translate(Language) <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                  <select class="form-control lang @error('language') is-invalid @enderror" id="language" name="language" >
                      <option value="">@translate(Select Provider)</option>
                      @foreach ($languages as $language)
                        <option value="{{ $language->name }}">{{ $language->name }}</option>
                      @endforeach

                  </select>
                    @error('language') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div>

            {{-- Meta Title --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-meta_title">
                    @translate(Meta Title)</label>
                <div class="col-lg-9">
                    <div class="bootstrap-tagsinput">
                        <input type="text"  placeholder="@translate(Enter Meta Title)" class=" @error('meta_title') is-invalid @enderror" id="val-meta_title" name="meta_title" data-role="tagsinput">
                          @error('meta_title') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                </div>
            </div>

            {{-- Meta Description --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="val-meta_description">
                    @translate(Meta Description)</label>
                <div class="col-lg-9">
                    <textarea id="val-meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" data-role="tagsinput"> {!! old('meta_description') !!}</textarea>
                      @error('meta_description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                </div>
            </div> -->

            {{-- Submit --}}
            <div class="form-group row">
                <label class="col-lg-3 col-form-label"></label>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary">
                        @translate(Submit)</button>
                </div>
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
        </form>
            <div class="form-group row" style="display: none;">
            <label class="col-lg-3 col-form-label" for="val-title"></label>
            <div class="col-lg-8">
                <input type="text" required
                        value="{{ old('logbook') }}"
                        class="form-control @error('logbook') is-invalid @enderror"
                        id="val-logbook" name="logbook" aria-required="true" autofocus> 
                    @error('logbook') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>
            <div class="col-lg-1"><button class="btn btn-success add-more" type="button"><i class="la la-trash"></i></button>
            </div>
    </div>
</div>
<!-- END:content -->
@endsection
@section('js-link')
@include('layouts.include.form.form_js')
@stop
@section('page-script')
<script type="text/javascript" src="{{ asset('assets/js/custom/course.js') }}"></script>
@stop
