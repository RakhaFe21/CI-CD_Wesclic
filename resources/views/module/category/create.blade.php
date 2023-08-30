<div class="card-body">
    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required>
        </div>
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Icon/Image)</label>
            <div class="custom-file">
                <input value="" name="icon" class="icon" type="hidden">
                @error('icon') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                <img class="category_preview rounded shadow-sm d-none" width="55" src="" alt="#Category icon">
                <br>
                <div id="mediaPreview"></div> <!-- Ini adalah div untuk menampilkan media -->
                <input type="file" id="mediaInput" class="d-none" accept="image/*"> <!-- Input file media yang tersembunyi -->
                <a href="javascript:void(0)" onclick="openMediaPicker()" class="btn btn-primary media-btn mt-2 p-2">Choose Media <i class="fa fa-cloud-upload ml-2" aria-hidden="true"></i> </a>
            </div>
        </div>
        
        
        
        <div class="form-group">
            <label>@translate(Parent Category)</label>
            <select class="form-control select2 w-100" name="parent_category_id">
                <option value="">@translate(No Parent Category Select)</option>
                @foreach($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>

<!-- Dalam halaman Anda -->
<div id="mediaManagerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMediaManager()">&times;</span>
        <!-- Di sini Anda akan memuat tampilan media manager -->
        <!-- Gantilah dengan tampilan media manager yang telah Anda buat -->
        <!-- Misalnya, Anda bisa memuatnya dengan menggunakan AJAX -->
        <div id="mediaManagerContent">
            <!-- Konten media manager akan dimuat di sini -->
        </div>
    </div>
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