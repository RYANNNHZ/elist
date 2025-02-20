<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $header }} | Page</title>
    <base href="{{ url('/') }}/">
    <link rel="shortcut icon" href="/images/icons/roti.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('icon/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="style.css">
    <style>
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s;
        }
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px;
        }
        #page-content-wrapper {
            flex-grow: 1;
            padding: 20px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light p-2 ">
                <h1> <i class="bi bi-card-checklist" style="color: #dd7600" ></i> <b>elists</b></h1>

            </div>

            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/list">catatan <i class="bi bi-card-checklist" style="color: #dd7600" ></i> </a>
            </div>

            <div class="list-group list-group-flush">
                <hr>
            </div>

            <small class="ms-3"><b>tags <i class="bi bi-threads"></i> </b></small>
            @forelse (Auth::user()->tags as $tag)
            <div class="list-group list-group-flush">
                <div class="d-flex align-items-center justify-content-between list-group-item list-group-item-action list-group-item-light p-3">
                    <a href="/tag/{{$tag->id}}" class="text-decoration-none text-dark flex-grow-1">{{ $tag->name }}</a>
                    <form action="/tag/{{ $tag->id }}" method="POST" class="d-inline mb-0">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bg-transparent border-0 p-0 fs-3">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                    <a class="text-dark mx-2" href="/tag/{{$tag->id}}/edit"><i class="bi bi-pencil"></i></a>
                </div>
            </div>

            @empty
                <small>there is no tag</small>
            @endforelse





            <hr>
            <small class="ms-3"><b>add tag <i class="bi bi-threads"></i> </b></small>
            <div id="wpAddTag" class="list-group list-group-flush ">
                <form action="/tag" method="POST" >
                    @csrf
                    <input type="text" name="name" class="form-control" >
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" >
                    <button type="submit" class="bg-transparent border-0 p-0 fs-3" ><i class="bi bi-plus"></i></button>
                </form>
            </div>

            <hr>
            <div class="p-2">
                <a href="/trash" style="text-decoration: none; color: #dd7600" >trash <i class="bi bi-recycle"></i> </a>
            </div>
            <hr>


        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid p-3 rounded-3" style="background-color: #ffbd72">
                    <div class="d-flex align-items-center w-100">
                        <!-- Sidebar Toggle (Tetap Ada) -->
                        <button class="btn btn-primary me-2" style="background-color: #ffe5b8; border: none; color: #dd7600" id="sidebarToggle">
                            <i class="bi bi-command"></i>
                        </button>

                        <!-- Search Form -->
                        <form role="search" method="POST" action="/search" class="flex-grow-1 d-none d-lg-block">
                            @csrf
                            <div class="input-group">
                                <input type="search" name="lists" placeholder="Search your product" class="form-control" />
                                <button class="btn bg-white" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Navbar Toggle Button -->
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>

                    <!-- Navbar Content -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Search Bar (Visible in Mobile) -->
                        <form role="search" method="POST" action="/search" class="mt-2 w-100 d-lg-none">
                            @csrf
                            <div class="input-group">
                                <input type="search" name="lists" placeholder="Search your product" class="form-control" />
                                <button class="btn bg-white" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- User Profile -->
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle" src="https://avatar.iran.liara.run/username?username={{ Auth::user()->username }}" alt="Profile" style="width: 2em; height: 2em;">
                                    <span>{{ Auth::user()->username }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    <a class="dropdown-item" href="/logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>



            <div class="container-fluid">
                @error('title')
                <div class="alert alert-danger my-3" role="alert">
                    {{ $message }}
                  </div>
            @enderror
                @error('description')
                <div class="alert alert-danger my-3" role="alert">
                    {{ $message }}
                  </div>
            @enderror
                @error('name')
                <div class="alert alert-danger my-3" role="alert">
                    {{ $message }}
                  </div>
            @enderror

            @if ($header === 'lists')
            <button type="button" class="btn btn-warning my-2" style="background-color: #ffe5b8; border: none;color: #dd7600" data-bs-toggle="modal" data-bs-target="#exampleModal">Create <i class="bi bi-plus"></i></button>
        @endif
                @yield('content')
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create list</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/list" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" id="title" class="fs-4 form-control border-0 shadow-none" required="tolong isikan" placeholder="Title..." name="title">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="description" class="form-control border-0 shadow-none"  name="description" placeholder="Description...">
                        </div>
                        <div class="mb-3">
                            <input type="date" id="description" class="form-control border-0 shadow-none"  name="expired" placeholder="" >
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label" onclick="closeEditTag()">tag</label>
                            <select class="form-select form-select-lg" name="tag">
                                @foreach (Auth::user()->tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" style="background-color: #ffe5b8; border: none;color: #dd7600" >Save <i class="bi bi-check" ></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Success!',
                text: {!! json_encode(session('success')) !!},
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif



    <script src="{{ url('js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.js') }}"></script>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("wrapper").classList.toggle("toggled");
        });

        let wpedittag = document.getElementById('wpEditTag');

        function closeEditTag(){
    wpedittag.innerHTML = `
        <label for="" class="form-label" onclick="openEditTag()">tag</label>
    `;
}




    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


</script>
</body>
</html>
