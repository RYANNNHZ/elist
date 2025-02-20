@extends('index')

@section('content')

<div>
    <div class="row my-3  mb-5">
        {{-- Tampilkan LIST yang PINNED DULU --}}
        @if ($pinnedLists->count() > 0)
    <small> pinned lists </small>
@endif

        @foreach ($pinnedLists as $list)
        <div class="col-12 col-lg-4 col-md-6 my-1">
            <div class="card text-dark rounded-4  {{$list->expired ? 'rounded-bottom-0' : ''}} border-0">
                <div class="card-body rounded-4 {{$list->expired ? 'rounded-bottom-0' : ''}} "
                    style="background-color: #ffdfa8; border: none;color: #dd7600"
                    onclick="window.location='{{ url('/list/' . $list->id) }}'"
                    style="cursor: pointer;">
                    <div class="card-header d-flex justify-content-between">
                        @foreach ($list->tags as $tag)
                        <div class="btn btn-warning" style="background-color: #ffe5b8; border: none;color: #dd7600"># {{$tag->name}}</div>
                        @endforeach
                        <div class="eventWrapper d-flex">
                            <form action="/list/{{ $list->id }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="mx-2 p-0 bg-transparent border-0" onclick="confirmDelete(event)" >
                                    <i class="bi bi-trash2-fill text-dark fs-3"></i>
                                </button>
                            </form>
                            <a href="{{ route('list.togglePin', $list->id) }}" class="text-dark fs-3">
                                @if($list->pin == 'pinned')
                                <i class="bi bi-pin-angle-fill"></i><!-- Pin aktif -->
                                @else
                                <i class="bi bi-pin-angle"></i><!-- Pin non-aktif -->
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="wrapper p-2">
                        <h4 class="card-title"><b>{{ $list->title }}</b></h4>
                        <p class="card-text">{{ $list->description }}</p>
                        <p class="text-end m-0">
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                </div>

                @php
                    $expiredDate = Carbon\Carbon::parse($list->expired);
                @endphp

                @if ($list->expired)
                    @if ($expiredDate->isToday())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">Ontime</small>
                    @elseif ($expiredDate->isPast())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">Ondeadline</small>
                    @elseif ($expiredDate->isTomorrow())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">OneDaybefore</small>
                    @endif
                @endif
            </div>
        </div>

        @endforeach
    </div>

    @if ($pinnedLists->count() > 0)
    <hr>
@endif

    <div class="row my-3 mt-5">
        {{-- Tampilkan LIST yang TIDAK PINNED --}}
        @forelse ($notPinnedLists as $list)
        <div class="col-12 col-lg-4 col-md-6 my-1">
            <div class="card text-dark rounded-4 {{$list->expired ? 'rounded-bottom-0' : ''}} border-0">
                <div class="card-body rounded-4 {{$list->expired ? 'rounded-bottom-0' : ''}}"
                    style="background-color: #ffdfa8; border: none;color: #dd7600"
                    onclick="window.location='{{ url('/list/' . $list->id) }}'"
                    style="cursor: pointer;">
                    <div class="card-header d-flex justify-content-between">
                        @foreach ($list->tags as $tag)
                        <div class="btn btn-warning" style="background-color: #ffe5b8; border: none;color: #dd7600"># {{$tag->name}}</div>
                        @endforeach
                        <div class="eventWrapper d-flex">
                            <form action="/list/{{ $list->id }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="mx-2 p-0 bg-transparent border-0">
                                    <i class="bi bi-trash2-fill text-dark fs-3"></i>
                                </button>
                            </form>
                            <a href="{{ route('list.togglePin', $list->id) }}" class="text-dark fs-3">
                                @if($list->pin == 'pinned')
                                <i class="bi bi-pin-angle-fill"></i><!-- Pin aktif -->
                                @else
                                <i class="bi bi-pin-angle"></i><!-- Pin non-aktif -->
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="wrapper p-2">
                        <h4 class="card-title"><b>{{ $list->title }}</b></h4>
                        <p class="card-text">{{ $list->description }}</p>
                        <p class="text-end m-0">
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                </div>

                @php
                    $expiredDate = Carbon\Carbon::parse($list->expired);
                @endphp

                @if ($list->expired)
                    @if ($expiredDate->isToday())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">Ontime</small>
                    @elseif ($expiredDate->isPast())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">Ondeadline</small>
                    @elseif ($expiredDate->isTomorrow())
                        <small class="btn btn-warning rounded-0 rounded-bottom-4" style="background-color:  #ffc560; color:#dd7600">OneDaybefore</small>
                    @endif
                @endif
            </div>
        </div>

        @empty
            <div class="col-12">

            </div>
        @endforelse
    </div>
</div>
<script>

    function confirmDelete(event) {
        event.preventDefault(); // Mencegah submit langsung

        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest("form").submit(); // Submit form kalau dikonfirmasi
            }
        });
    }

</script>
@endsection
