@extends('layouts.master')
@section('title','Message List')
@section('parentPageTitle', 'All Ticket')
@section('content')
<div class="card m-2">
    <div class="card-header">
        <div class="float-left">
            <h2 class="card-title">@translate(Student Message List)</h2>
        </div>
        <div class="float-right">
            <div class="row">
            </div>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S/L</th>
                    <th>@translate(Siswa)</th>
                    <th>@translate(Pesan Terakhir)</th>
                    <th>@translate(Tanggal)</th>
                    <th>@translate(Aksi)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enroll as $item)
                @if($item->messagesForInbox == !null)
                <tr>
                    <td>{{ ($loop->index+1) + ($enroll->currentPage() - 1)*$enroll->perPage() }}</td>
                    <td>
                        @translate(Siswa): <a target="_blank"
                            href="{{route('students.show',$item->user_id)}}">{{studentDetails($item->user_id)->name ??
                            'N/A'}}</a>
                        <br />
                        @translate(Pelatihan): <a target="_blank"
                            href="{{ route('course.show',[$item->course_id,$item->enrollCourse->slug]) }}">{{$item->enrollCourse->title
                            ?? 'N/A'}}</a>
                    </td>
                    <td>
                        <a target="_blank" href="{{ route('messages.show', $item->id) }}">
                            {{$item->messagesForInbox->content}}
                            <span class="badge badge-dark">
                                {{ $item->messagesForInbox->user_id == \Illuminate\Support\Facades\Auth::id() ?
                                '@translate(Kirim)' : '@translate(Balas)'}}
                            </span>
                        </a>

                    </td>
                    <td>
                        {{date('d-M-y',strtotime($item->created_at))}}
                    </td>
                    <td>
                        <div class="kanban-menu">
                            <div class="dropdown">
                                <button class="btn btn-link p-0 m-0 border-0 l-h-20 font-16" type="button"
                                    id="KanbanBoardButton1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                <div class="dropdown-menu dropdown-menu-right action-btn"
                                    aria-labelledby="KanbanBoardButton1" x-placement="bottom-end">
                                    <a class="dropdown-item" href="{{ route('comments.delete', $item->id) }}">
                                        <i class="feather icon-delete mr-2"></i>@translate(Hapus Pesan)</a>
                                    <a class="dropdown-item" href="{{ route('messages.show', $item->id) }}">
                                        <i class="feather icon-edit-2 mr-2"></i>@translate(Pesan)</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr></tr>
                <tr>
                    <td>
                        <h3 class="text-center">@translate(Tidak Ada Data Ditemukan)</h3>
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                @endforelse
            </tbody>
            <div class="float-left">
                {{ $enroll->links() }}
            </div>
        </table>
    </div>
</div>

@endsection