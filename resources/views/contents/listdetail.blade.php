@extends('index')

@section('content')
<!-- Alert Error -->
@error('task')
<div class="alert alert-danger my-3" role="alert">
    {{ $message }}
</div>
@enderror

<!-- Button Tambah Task -->
<form method="POST" action="/task">
    @csrf
    <div class="modal-body">
        <input type="hidden" value="{{ $list->id }}" name="id">
        <input type="text" name="task" placeholder="Add task..." class="form-control">
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </div>
</form>

<!-- Edit Title -->
<div id="wpEditTitle">
    <h1 id="title" onclick="openEditTitle()">{{ $list->title }}</h1>
</div>

<!-- Edit Description -->
<div id="wpEditDescription">
    @if ($list->description)
        <p id="description" onclick="openEditDescription()">{{ $list->description }}</p>
    @else
        <button class="btn btn-secondary" onclick="openEditDescription()">Add Description</button>
    @endif
</div>

<!-- Tags -->
<div id="wpTags">
    <p class="bg-warning">{{ $list->tags->pluck('name')->join(', ') }}</p>
</div>

<!-- Delete List -->
<form action="/list/{{ $list->id }}" method="POST">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger mx-2">Delete List</button>
</form>

<!-- Tasks List -->
<div wire:poll>
    @if ($list->tasks->isNotEmpty())
        @foreach ($list->tasks as $task)
        <div class="form-check border rounded-2 p-3 d-flex justify-content-between task-container">
            <div class="d-flex align-items-center">
                <input class="form-check-input ms-1" type="checkbox" {{ $task->is_done == 'done' ? 'checked' : '' }}>
                <label class="form-check-label ms-2">
                    <p class="task-text" data-task-id="{{ $task->id }}" data-original-task="{{ $task->task }}">{{ $task->task }}</p>
                </label>
            </div>

            <div class="d-flex">
                <!-- Toggle Done Status -->
                <form action="/task/{{ $task->id }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="is_done" value="{{ $task->is_done }}">
                    <button type="submit" class="btn btn-warning mx-2">
                        <i class="bi bi-check"></i>
                    </button>
                </form>

                <!-- Delete Task -->
                <form action="/task/{{ $task->id }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger mx-2">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    @else
        <p class="text-muted">No tasks available.</p>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener("click", function (event) {
            if (event.target.classList.contains("task-text")) {
                openEditTask(event.target);
            } else if (event.target.classList.contains("cancel-edit")) {
                closeEditTask(event.target);
            }
        });
    });

    function openEditTask(taskElement) {
        let taskId = taskElement.getAttribute("data-task-id");
        let taskText = taskElement.getAttribute("data-original-task");

        taskElement.outerHTML = `
            <form action="/task/${taskId}" method="POST">
                @method('PATCH')
                @csrf
                <input type="text" name="task" class="form-control border-none" value="${taskText}">
                <button type="submit" class="btn btn-warning">Edit</button>
                <button type="button" class="btn btn-dark cancel-edit" data-task-id="${taskId}" data-original-task="${taskText}">Close</button>
            </form>
        `;
    }

    function closeEditTask(cancelButton) {
        let taskId = cancelButton.getAttribute("data-task-id");
        let originalText = cancelButton.getAttribute("data-original-task");

        cancelButton.closest("form").outerHTML = `
            <p class="task-text" data-task-id="${taskId}" data-original-task="${originalText}">${originalText}</p>
        `;
    }
</script>


<!-- Edit Jadwal -->
<div id="wpEditJadwal">
    <small class="text-muted" onclick="openEditJadwal()">
        Jadwal: {{ \Carbon\Carbon::parse($list->expired)->format('M d') }}
    </small>
</div>

<!-- Last Edited -->
<div>
    <small class="text-muted">Edited: {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}</small>
</div>

<!-- Modal Add Task -->
<div class="modal fade" id="modaladdtask" tabindex="-1" aria-labelledby="modaladdtaskLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

        </div>
    </div>
</div>

<script>
    function openEditDescription() {
        document.getElementById('wpEditDescription').innerHTML = `
            <form action="/list/{{$list->id}}" method="POST">
                @method('PATCH')
                @csrf
                <input type="text" name="description" class="form-control" value="{{$list->description ?? ''}}">
                <button type="submit" class="btn btn-warning mt-2">Save</button>
                <button type="button" class="btn btn-dark mt-2" onclick="closeEditDescription()">Cancel</button>
            </form>
        `;
    }

    function closeEditDescription() {
        document.getElementById('wpEditDescription').innerHTML = `
            @if ($list->description)
                <p id="description" onclick="openEditDescription()">{{ $list->description }}</p>
            @else
                <button class="btn btn-secondary" onclick="openEditDescription()">Add Description</button>
            @endif
        `;
    }

    function openEditTitle() {
        document.getElementById('wpEditTitle').innerHTML = `
            <form action="/list/{{$list->id}}" method="POST">
                @method('PATCH')
                @csrf
                <input type="text" name="title" class="form-control" value="{{$list->title}}">
                <button type="submit" class="btn btn-warning mt-2">Save</button>
                <button type="button" class="btn btn-dark mt-2" onclick="closeEditTitle()">Cancel</button>
            </form>
        `;
    }

    function closeEditTitle() {
        document.getElementById('wpEditTitle').innerHTML = `
            <h1 id="title" onclick="openEditTitle()">{{ $list->title }}</h1>
        `;
    }

    function openEditJadwal() {
        document.getElementById('wpEditJadwal').innerHTML = `
            <form action="/list/{{$list->id}}" method="POST">
                @method('PATCH')
                @csrf
                <input type="date" name="expired" class="form-control" value="{{$list->expired}}">
                <button type="submit" class="btn btn-warning mt-2">Save</button>
                <button type="button" class="btn btn-dark mt-2" onclick="closeEditJadwal()">Cancel</button>
            </form>
        `;
    }

    function closeEditJadwal() {
        document.getElementById('wpEditJadwal').innerHTML = `
            <small class="text-muted" onclick="openEditJadwal()">
                Jadwal: {{ \Carbon\Carbon::parse($list->expired)->format('M d') }}
            </small>
        `;
    }
</script>
@endsection
