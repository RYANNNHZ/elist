@extends('blank')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register <i class="bi bi-book-fill"></i> </p>

                <form method="POST" action="/register" class="mx-1 mx-md-4">
                    @csrf
                    @method('POST')
                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            @error('username')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                            <input type="text" id="form3Example1c" name="username" class="form-control" />
                            <label class="form-label" for="form3Example1c">Userame</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            @error('email')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                            <input type="email" id="form3Example3c" name="email" class="form-control" />
                            <label class="form-label" for="form3Example3c">Email</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            @error('password')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" />
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <label class="form-label" for="password">Password</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <p class="text-dark me-4"> have an account <a class="text-decoration-none" href="/loginpage">Login</a> </p>
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-dark btn-lg">Register</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>



<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordInput = document.getElementById('password');
        let icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
