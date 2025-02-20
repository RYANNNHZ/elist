@extends('index')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row my-3">
            <div class="offset-0 offset-md-3 col-12 col-md-6">
                <div class="card text-center p-5 w-100">
                    <img class="card-img-top w-50 mx-auto" src="https://avatar.iran.liara.run/username?username={{ Auth::user()->username }}" alt="Title" />
                    <div class="card-body">
                        <h4 class="card-title">{{ Auth::user()->username }}</h4>
                        <p class="card-text">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="card mt-3 p-3">
                        <h5>Task Summary</h5>
                        <a href="/list">Total Lists: {{ $totalLists }}</a>
                        <a href="/ondeadline">deadline Lists: {{ $expiredLists }}</a>
                        <a href="/ontime">On-time Lists: {{ $onTimeLists }}</a>
                        <a href="/onedaybefore" >One Day Before Lists: {{ $onDayBefore }}</a >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
