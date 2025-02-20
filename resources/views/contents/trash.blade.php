@extends('index')

@section('content')

<div>
    <div class="row my-3">

        <a href="{{ url('/restore-all') }}" class="btn btn-success" onclick="return confirm('Yakin ingin mengembalikan semua task?');">
            Restore All
        </a>

        <a href="{{ url('/delete-all-permanent') }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus semua task secara permanen?');">
            Delete All Permanently
        </a>


        @forelse ($lists as $list)
            <div class="col-12 col-lg-4 col-md-6 my-2">
                <a href="/list/{{ $list->id }}" wire:navigate.hover style="text-decoration: none">
                    <div class="card text-dark">
                        <div class="card-body">
                            <small>
                                <a href="{{ url('/restore/' . $list->id) }}" class="text-primary">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                                <a href="{{ url('/delete-permanent/' . $list->id) }}" class="text-danger" onclick="return confirm('Yakin ingin menghapus permanen?');">
                                    <i class="bi bi-trash"></i>
                                </a>

                            </small>
                            <h4 class="card-title">{{ $list->title }}</h4>
                            <p class="card-text">{{ $list->description }}</p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}</small>
                            </div>
                            @php
                            $expiredDate = Carbon\Carbon::parse($list->expired);
                            $now = now();
                        @endphp

                        @if ($list->expired)
                            @if ($expiredDate->isToday())
                                <small class="text-warning">Ontime</small>
                            @elseif ($expiredDate->isPast())
                                <small class="text-danger">Ondeadline</small>
                            @elseif ($expiredDate->isTomorrow())
                                <small class="text-info">OneDaybefore   </small>
                            @endif
                        @endif

                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <h1 class="fs-1 text-center">tidak ada list yang kamu cari</h1>
                </div>
                @endforelse
            </div>
        </div>
@endsection
