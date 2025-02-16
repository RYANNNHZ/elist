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




<div id="wpEditTitle">
<h1 id="title" onclick="openEdittitle()">{{ $list->title }}</h1>
</div>
<div id="wpEditDescription">
<p id="description" onclick="openEditdescription()">{{ $list->description }}</p>
</div>




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
            <label id="wpTask"class="form-check-label ms-2" for="flexCheckDefault">
               <p {{ $task->task }} id="task" onclick="openEditTask()" > {{ $task->task }}</p>
            </label>
        </div>

        <form action="/task/{{ $task->id }}" method="POST" >
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger mx-2">
                <i class="bi bi-x-lg mx-5"></i>
            </button>
        </form>
      </div>


      <script>
            function openEditTask(){
        wpTask.innerHTML = `
<form action="/task/{{$task->id}}" method="POST">
    @method('PATCH')
    @csrf
    <input type="text" name="task" class="form-control border-none" value="{{$task->task}}">
    @error('task')
    <small class="text-danger">{{$message}}</small>
    @enderror
    <button type="submit" class="btn btn-warning" >edit</button>
   <button class="btn btn-dark" onclick="closeEditTask()">close</button>
</form>
        `;
    }

    function closeEditTask(){
        wpTask.innerHTML = `
          <p {{ $task->task }} id="task" onclick="openEditTask()" > {{ $task->task }}</p>
        `;
    }
      </script>


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


<script>
    // function editTitle(){
    // }
    let wpEditTitle = document.getElementById('wpEditTitle');
    let wpEditDescription = document.getElementById('wpEditDescription');
    let wpTask = document.getElementById('wpTask');


    function openEdittitle(){
        wpEditTitle.innerHTML = `
<form action="/list/{{$list->id}}" method="POST">
    @method('PATCH')
    @csrf
    <input type="text" name="title" class="form-control border-none" value="{{$list->title}}">
    @error('title')
    <small class="text-danger">{{$message}}</small>
    @enderror
    <button type="submit" class="btn btn-warning" >edit</button>
   <button class="btn btn-dark" onclick="closeEdittitle()">close</button>
</form>
        `;
    }


    function closeEdittitle(){
        wpEditTitle.innerHTML = `
        <h1 id="title" onclick="openEdittitle()">{{ $list->title }}</h1>
        `;
    }

    function closeEdittitle(){
        wpEditTitle.innerHTML = `
        <h1 id="title" onclick="openEdittitle()"openEditTask()>{{ $list->title }}</h1>
        `;
    }

    function openEditdescription(){
        wpEditDescription.innerHTML = `
<form action="/list/{{$list->id}}" method="POST">
    @method('PATCH')
    @csrf
    <input type="text" name="description" class="form-control border-none" value="{{$list->description}}">
    @error('description')
    <small class="text-danger">{{$message}}</small>
    @enderror
    <button type="submit" class="btn btn-warning" >edit</button>
   <button class="btn btn-dark" onclick="closeEditdescription()">close</button>
</form>
        `;
    }

    function closeEditdescription(){
        wpEditDescription.innerHTML = `
        <p id="title" onclick="openEditdescription()">{{ $list->description }}</p>
        `;
    }

</script>
@endsection
