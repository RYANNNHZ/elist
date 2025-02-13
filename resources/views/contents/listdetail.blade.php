@extends('index')

@section('content')
<!-- Button trigger modal -->
@error('task')
<div class="alert alert-danger my-3" role="alert">
    {{ $message }}
  </div>
@enderror

<button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modaladdtask">
    add task
  </button>




<h1>{{ $list->title }}</h1>
<form action="/list/{{ $list->id }}" method="POST" >
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger mx-2">
       delete list
    </button>
</form>




<div wire:poll class="">
    @foreach ($list->tasks as $task)
    <div class="form-check border rounded-2 p-3 d-flex justify-between">
        <div class="d-flex ">
            <input class="form-check-input ms-1" type="checkbox" value="" id="flexCheckDefault" {{ $task->is_done == 'done' ? 'checked' : '' }} >
            <label class="form-check-label ms-2" for="flexCheckDefault">
                {{ $task->task }}
            </label>
        </div>

        <form action="/task/{{ $task->id }}" method="POST" >
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger mx-2">
                <i class="bi bi-x-lg mx-5"></i>
            </button>
        </form>

        <button type="button" class="btn btn-warning my-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            edit
          </button>
      </div>
    @endforeach
</div>


<div class="modal fade" id="modaladdtask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="/task">
            @csrf
            <div class="modal-body">
                <input type="hidden" value="{{ $list->id }}" name="id">
                <input type="text" name="task" placeholder="add task..." class="form-control">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Understood</button>
            </div>
        </form>
        </div>
    </div>
  </div>




@endsection
