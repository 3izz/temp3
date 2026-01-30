<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
     public function home(Request $request){
        $role = $request->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'coach') {
            return redirect()->route('coach.dashboard');
        }

        return view('dashboard');
    }




   
   public function index(Request $request)
{
    $user = Auth::user(); // جلب المستخدم الحالي من نظام Auth

    if ($user) {
        // تحقق من الدور
        if ($user->role === 'admin') {
            return view('admin.dashboard', ['user' => $user]);
        }

        if ($user->role === 'coach') {
            return redirect()->route('coach.dashboard');
        }

        // المستخدم العادي
        return view('home', ['user' => $user]);
    } else {
        // لا يوجد مستخدم مسجل الدخول
        return redirect()->route('home');
    }
}

    public function post(){
          return view('admin.post');
     }

        public function createpost(){
            return view('admin.createpost');
        }
        public function indexpage(){
            return view('index');
        }
}


