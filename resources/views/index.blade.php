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
                <img src="favicon.png" style="width: 2em" alt=""> <b>elists</b>
            </div>

            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/list"><b>catatan</b></a>
            </div>

            <div class="list-group list-group-flush">
                ++++++++++++++++++++
            </div>

            @forelse (Auth::user()->tags as $tag)
            <div class="list-group list-group-flush d-flex">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/tag/{{$tag->id}}"><b>{{ $tag->name }}</b></a>

                <form action="/tag/{{ $tag->id }}" method="POST" >
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger mx-2">
                       delete tag
                    </button>
                </form>
                <a class="btn btn-warning w-50" href="/tag/{{$tag->id}}/edit" > edit </a>
            </div>
            @empty
                <small>there is no tag</small>
            @endforelse





            <div id="wpAddTag" class="list-group list-group-flush ">
                <form action="/tag" method="POST" >
                    @csrf
                    <input type="text" name="name" class="form-control" >
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" >
                    <button type="submit" class="btn btn-warning" >add tag</button>
                </form>
            </div>


        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="bi bi-command"></i>
                    </button>


                    <div class="col-md-5 my-auto ms-3">
                        <form role="search" method="POST" action="/search">
                            @method('post')
                            @csrf
                            <div class="input-group">
                                <input type="search" name="lists" placeholder="Search your product" class="form-control" />
                                <button class="btn bg-white" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>



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
                                    <img class="card-img-top" src="https://avatar.iran.liara.run/username?username={{ Auth::user()->username }}" alt="Title" style="width:2em" />
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
                            <input type="text" id="title" class="fs-4 form-control border-0 shadow-none" required="tolong isikan" placeholder="Title..." name="title">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="description" class="form-control border-0 shadow-none"  name="description" placeholder="Description...">
                        </div>
                        <div class="mb-3">
                            <input type="date" id="description" class="form-control border-0 shadow-none"  name="expired" placeholder="" >
                        </div>
                        <div class="mb-3">
                            <div id="wpEditTag" onclick="openEditTag()" class="mb-3">
                                <label for="" class="form-label" onclick="openEditTag()" >tag</label>
                            </div>

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

        let wpedittag = document.getElementById('wpEditTag');

        function closeEditTag(){
    wpedittag.innerHTML = `
        <label for="" class="form-label" onclick="openEditTag()">tag</label>
    `;
}



        function openEditTag(){
    wpedittag.innerHTML = `
        <label for="" class="form-label" onclick="closeEditTag()">tag</label>
        <select class="form-select form-select-lg" name="tag">
            @foreach (Auth::user()->tags as $tag)
            <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        </select>
    `;
}



    </script>
</body>
</html>
