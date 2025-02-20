@extends('index')

@section('content')
<div class="container">
    <div class="row my-3">
        <div class="col-12 d-flex gap-2">
            <a href="{{ url('/restore-all') }}" class="btn btn-warning text-dark fw-bold d-flex align-items-center gap-2"
                onclick="return confirm('Yakin ingin mengembalikan semua task?');">
                <i class="bi bi-arrow-counterclockwise"></i> Restore All
            </a>
            <a href="{{ url('/delete-all-permanent') }}" class="btn btn-danger fw-bold d-flex align-items-center gap-2"
                onclick="return confirm('Yakin ingin menghapus semua task secara permanen?');">
                <i class="bi bi-trash"></i> Delete All Permanently
            </a>
        </div>

        @forelse ($lists as $list)
        <div class="col-12 col-lg-4 col-md-6 my-2">
            <div class="card shadow-sm rounded-4 {{$list->expired ? 'rounded-bottom-0' : ''}} border-0">
                <div class="card-body rounded-4 {{$list->expired ? 'rounded-bottom-0' : ''}} p-3 text-dark"
                    style="background-color: #ffdfa8; cursor: pointer;"
                    onclick="window.location='{{ url('/list/' . $list->id) }}'">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            @foreach ($list->tags as $tag)
                            <span class="badge text-dark" style="background-color: #ffe5b8;">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/restore/' . $list->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                            </a>
                            <a href="{{ url('/delete-permanent/' . $list->id) }}" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                onclick="return confirm('Yakin ingin menghapus permanen?');">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>

                    <h4 class="fw-bold">{{ $list->title }}</h4>
                    <p class="mb-2">{{ $list->description }}</p>
                    <p class="text-end m-0">
                        <small class="text-muted">{{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}</small>
                    </p>
                </div>

                @php
                $expiredDate = Carbon\Carbon::parse($list->expired);
                @endphp

                @if ($list->expired)
                <small class="btn rounded-0 rounded-bottom-4 text-dark"
                    style="background-color: #ffc560;">
                    @if ($expiredDate->isToday())
                    Ontime
                    @elseif ($expiredDate->isPast())
                    Ondeadline
                    @elseif ($expiredDate->isTomorrow())
                    OneDaybefore
                    @endif
                </small>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center">

        </div>
        @endforelse
    </div>
</div>
@endsection
