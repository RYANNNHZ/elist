<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
  public function loginPage(){
    return view('auth.login')->with(['header' => 'login']);
}

public function registerPage(){
    return view('auth.register')->with(['header' => 'register']);
  }


  public function login(Request $request){
    $request->validate([
        'username'=>'required|min:4',
        'password'=>'required|min:8'
    ],[
        'username.required'=>'anda wajib memasuka username',
        'username.min'=>'minimal password 4 karakter',
        'password.required'=>'anda wajib memasuka password',
        'password.min'=>'minimal password 8 karakter',
    ]);

    if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
        return redirect('/list');
    }else{
        return redirect('/loginpage')->with(['header'=>'login','gagallogin','login yang anda lakukan tidak valid']);
    }
}


public function register(Request $request){
    // $request->dd();
    $request->validate([
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8'
    ], [
        'email.required' => 'maaf anda harus memasukan email terlebih dahulu',
        'password.required' => 'maaf anda harus memasukan password terlebih dahulu',
        'username.required' => 'maaf anda harus memasukan username terlebih dahulu',
        'username.unique' => 'maaf sepertinya username yang anda masukan sudah ada mohon ganti username dengan username baru🙏',
        'email.email' => 'maaf anda  salah memasukan format email tolong masukan email dengan format yang benar',
        'email.unique' => 'maaf email yang anda masukan sudah di pakai',
        'password.min' => 'password minimal wajib 8 karakter',
    ]);


    User::create([
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'role' => 'user',
        'password' => Hash::make($request->input('password'))
        // 'password' => Hash::make($request->input('password'))
    ]);

    if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
        return redirect('/list');
    }else{
        return redirect('/registerpage')->with(['header'=>'register','gagalRegister','register yang anda lakukan tidak valid']);
    }
}


public function profile() {
    $user = Auth::user();

    // Ambil data list berdasarkan user
    $totalLists = $user->lists()->count();
    $expiredLists = $user->lists()->whereNotNull('expired')->where('expired', '<', now())->count();
    $onTimeLists = $user->lists()
    ->whereNotNull('expired')
    ->whereDate('expired', now()->toDateString()) // Pastikan hanya tanggal yang sama
    ->count();

    $onDayBefore = $user->lists()->whereNotNull('expired')->whereDate('expired', now()->addDay()->toDateString())->count();

    return view('contents.profile')->with([
        'header' => 'profile',
        'totalLists' => $totalLists,
        'expiredLists' => $expiredLists,
        'onTimeLists' => $onTimeLists,
        'onDayBefore' => $onDayBefore
    ]);
}




public function logout(){
    Auth::logout();
    return redirect('/');
}

}
