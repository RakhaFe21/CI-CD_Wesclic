<div class="card-body">
    <form action="{{route('categories.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$category->id}}">
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required value="{{$category->name}}">
        </div>
        @if($category->icon != null)
            <img src="{{filePath($category->icon)}}" width="80" height="80" class="img-thumbnail">
        @endif
        <div class="form-group">
            <label>@translate(Icon/Image)</label>
            {{-- <input class="form-control-file" type="file" name="newIcon"> --}}

            <input value="{{ $category->icon }}" name="icon" class="icon" type="hidden">
            
                <br>
                <img class="category_preview rounded shadow-sm d-none" width="60" src="" alt="#Category icon">  

                <br>

                <div id="mediaPreview"></div> <!-- Ini adalah div untuk menampilkan media -->
                <input type="file" id="mediaInput" class="d-none" accept="image/*"> <!-- Input file media yang tersembunyi -->
                <a href="javascript:void(0)" onclick="openMediaPicker()" class="btn btn-primary media-btn mt-2 p-2">Choose Media <i class="fa fa-cloud-upload ml-2" aria-hidden="true"></i> </a>x

        </div>
        <div class="form-group">
            <label>@translate(Parent Category)</label>
            <select class="form-control kt-select2 width-full" id="kt_select2_3" name="parent_category_id">
                <option value="0">@translate(No Parent Category Select)</option>
                @foreach($categories as $item)
                    @if($item->id != $category->id)
                        <option
                            value="{{$item->id}}" {{$category->parent_category_id == $item->id ? 'selected': null}}>{{$item->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Update)</button>
        </div>

    </form>
</div>

<script>
    function openMediaPicker() {
        // Ketika tombol "Choose Media" diklik, klik input file media secara otomatis
        document.getElementById('mediaInput').click();
    }

    // Fungsi ini akan dipanggil ketika pengguna memilih file media
    document.getElementById('mediaInput').addEventListener('change', function (event) {
        var mediaPreview = document.getElementById('mediaPreview');
        mediaPreview.innerHTML = ''; // Hapus tampilan media sebelumnya (jika ada)

        var file = event.target.files[0];
        if (file) {
            // Buat elemen gambar untuk menampilkan media
            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 55;
            img.className = 'rounded shadow-sm';

            // Tambahkan gambar ke div tampilan media
            mediaPreview.appendChild(img);
        }
    });
</script>
