@extends('index')

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="/tag/{{$tag->id}}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <input type="text" id="title" class="fs-4 form-control border-0 shadow-none" value="{{$tag->name}}" name="tag_name">
                @error('tag_name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection
