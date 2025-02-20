@extends('blank')

@section('content')
<div class="container-fluid p-5">
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card" style="height: 500px;border: none;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="mb-4 text-dark">Hello, nice to meet you  👋.</h1>
                    <p class="mb-5" >welcome to elist you can increast your productifity with elist manage your task now on elist</p>
                    <div class="wrapper d-flex mt-5">
                        <a href="/registerpage" class="btn btn-success mx-2 rounded-4" style="border: none;width: 10em; background-color: #ffa200;"><b>Register</b></a>
                        <a href="/loginpage" class="btn btn-success mx-2 rounded-4" style="border: none;width: 10em; background-color: #ffa200;"><b>Login</b></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-0 col-md-7" class=" d-none d-md-flex">
            <img src="elist.png" class="w-100 rounded-4" alt="">
        </div>
    </div>
</div>
@endsection
