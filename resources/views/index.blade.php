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
            <div class="sidebar-heading border-bottom bg-light">
                <img src="favicon.png" style="width: 2em" alt=""> <b>remindme</b>
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/">List</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="bi bi-command"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            @if ($header === 'lists')
                            <li class="nav-item active">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Create</button>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                </a>
                                <h4>{{ Auth::user()->username }}</h4>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    <a class="dropdown-item" href="/logout">logout</a>
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

                @yield('content')
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/list" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" id="title" class="fs-4 form-control border-0 shadow-none" placeholder="Title..." name="title">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="description" class="form-control border-0 shadow-none"  name="'description" placeholder="Description...">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.js') }}"></script>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("wrapper").classList.toggle("toggled");
        });
    </script>
</body>
</html>
