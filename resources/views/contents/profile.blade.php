@extends('index')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row my-3">
            <div class="offset-0 offset-md-3 col-12 col-md-6">
                <div class="card text-center p-5 w-100 shadow-lg" style="border: none;">
                    <img class="card-img-top w-50 mx-auto rounded-circle" src="https://avatar.iran.liara.run/username?username={{ Auth::user()->username }}" alt="Profile Picture" />
                    <div class="card-body">
                        <h4 class="card-title">{{ Auth::user()->username }}</h4>
                        <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="card mt-3 p-3 shadow-sm" style="border-radius: 10px;">
                        <h5 class="text-center fw-bold" style="color: #dd7600;">Task Summary</h5>
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="/list" class="text-decoration-none">
                                    <div class="card p-3 text-center shadow-sm">
                                        <small class="text-muted">Total Lists</small>
                                        <h3 style="color: #dd7600; font-weight: bold;">{{ $totalLists }}</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/ondeadline" class="text-decoration-none">
                                    <div class="card p-3 text-center shadow-sm">
                                        <small class="text-muted">Deadline Lists</small>
                                        <h3 style="color: #dd7600; font-weight: bold;">{{ $expiredLists }}</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/ontime" class="text-decoration-none">
                                    <div class="card p-3 text-center shadow-sm">
                                        <small class="text-muted">On-time Lists</small>
                                        <h3 style="color: #dd7600; font-weight: bold;">{{ $onTimeLists }}</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/onedaybefore" class="text-decoration-none">
                                    <div class="card p-3 text-center shadow-sm">
                                        <small class="text-muted">One Day Before</small>
                                        <h3 style="color: #dd7600; font-weight: bold;">{{ $onDayBefore }}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
