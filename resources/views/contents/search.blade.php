@extends('index')

@section('content')

<div>
    <div class="row my-3">
        @forelse ($lists as $list)
            <div class="col-12 col-lg-4 col-md-6 my-2">
                <a href="/list/{{ $list->id }}" wire:navigate.hover style="text-decoration: none">
                    <div class="card text-dark">
                        <div class="card-body">
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
