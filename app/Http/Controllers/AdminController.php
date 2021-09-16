<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function login(){
        return view('admin.login',[]);
    }
    public function loginf(Request $request)
    {
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return redirect("admin");
        }else{
            return redirect("backoffice");
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();$request->session()->invalidate();
        return redirect("backoffice");
    }
}
