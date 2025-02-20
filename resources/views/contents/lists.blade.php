@extends('index')

@section('content')

<div>
    <div class="row my-3">
        {{-- Tampilkan LIST yang PINNED DULU --}}
        @if ($pinnedLists->count() > 0)
    <h1>Pinned Lists</h1>
@endif

        @foreach ($pinnedLists as $list)
            <div class="col-12 col-lg-4 col-md-6 my-1 mb-5">
                <a href="/list/{{ $list->id }}" style="text-decoration: none">
                    <div class="card text-dark">
                        <div class="card-body">
                            <h4 class="card-title">{{ $list->title }}</h4>
                            <p class="card-text">{{ $list->description }}</p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}
                            </small>
                        </div>

                        @php
                            $expiredDate = Carbon\Carbon::parse($list->expired);
                        @endphp

                        @if ($list->expired)
                            @if ($expiredDate->isToday())
                                <small class="text-warning">Ontime</small>
                            @elseif ($expiredDate->isPast())
                                <small class="text-danger">Ondeadline</small>
                            @elseif ($expiredDate->isTomorrow())
                                <small class="text-info">OneDaybefore</small>
                            @endif
                        @endif

                        <a href="{{ route('list.togglePin', $list->id) }}" class="text-dark">
                            @if($list->pin == 'pinned')
                            <i class="bi bi-pin-angle-fill"></i><!-- Pin aktif -->
                            @else
                            <i class="bi bi-pin-angle"></i><!-- Pin non-aktif -->
                            @endif
                        </a>
                        

                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row my-3">
        {{-- Tampilkan LIST yang TIDAK PINNED --}}
        @forelse ($notPinnedLists as $list)
            <div class="col-12 col-lg-4 col-md-6 my-5">
                <a href="/list/{{ $list->id }}" style="text-decoration: none">
                    <div class="card text-dark">
                        <div class="card-body">
                            <h4 class="card-title">{{ $list->title }}</h4>
                            <p class="card-text">{{ $list->description }}</p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}
                            </small>
                        </div>

                        @php
                            $expiredDate = Carbon\Carbon::parse($list->expired);
                        @endphp

                        @if ($list->expired)
                            @if ($expiredDate->isToday())
                                <small class="text-warning">Ontime</small>
                            @elseif ($expiredDate->isPast())
                                <small class="text-danger">Ondeadline</small>
                            @elseif ($expiredDate->isTomorrow())
                                <small class="text-info">OneDaybefore</small>
                            @endif
                        @endif
                        <a href="{{ route('list.togglePin', $list->id) }}" class="text-dark">
                            @if($list->pin == 'pinned')
                            <i class="bi bi-pin-angle-fill"></i><!-- Pin aktif -->
                            @else
                            <i class="bi bi-pin-angle"></i><!-- Pin non-aktif -->
                            @endif
                        </a>
                        
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <h1 class="fs-1 text-center">Don't forget to list your task 🙌</h1>
            </div>
        @endforelse
    </div>
</div>

@endsection
