<div class="card-body">
    <form action="{{ route('student.logbook.courses.modal.store', ['user_id' => $user_id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-3">Peserta : <b>{{ $student->name }}</b></div>
        @forelse ($logbooks as $logbook)
            <div class="form-check">
                <input type="checkbox" name="logbook_id[]" value="{{ $logbook->id }}" class="form-check-input"
                    id="exampleCheck-{{ $logbook->id }}" @if (in_array($logbook->id, $logbook_students)) checked @endif>
                <label class="form-check-label" for="exampleCheck-{{ $logbook->id }}">{{ $logbook->name }}</label>
            </div>
        @empty
          <div>Logbook pada pelatihan ini kosong. Silakan <a href="{{ route('course.edit',[$course_id,$course->slug])}}">tambahkan</a> terlebih dahulu.</div>
        @endforelse


        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">Simpan Perubahan</button>
        </div>

    </form>
</div>
