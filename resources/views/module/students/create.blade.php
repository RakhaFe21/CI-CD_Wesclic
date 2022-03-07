<div class="card-body">
    <form action="{{ route('student.store.modal') }}" method="post" enctype="multipart/form-data">
        @csrf


        <div class="form-group">
            <label>Nama Lengkap <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="" required>
        </div>

        <div class="form-group">
            <label>NIK <span class="text-danger">*</span></label>
            <input class="form-control" name="nik" placeholder="" required>
        </div>

        <div class="form-group">
            <label>Username <span class="text-danger">*</span></label>
            <input class="form-control" name="username" placeholder="" required>
        </div>

        <div class="form-group">
            <label>No. HP/Telp <span class="text-danger">*</span></label>
            <input class="form-control" name="phone" placeholder="" required>
        </div>

        <div class="form-group">
            <label>@translate(Password) <span class="text-danger">*</span></label>
            <input class="form-control" type="password" name="password" placeholder="" required>
        </div>

        <div class="form-group">
            <label>@translate(Confirm password) <span class="text-danger">*</span></label>
            <input class="form-control" type="password" name="confirmed" placeholder="" required>
        </div>
       
      
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>



