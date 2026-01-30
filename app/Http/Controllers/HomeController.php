<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // داتا المستخدم الحالي
        $user = Auth::user();

        // داتا الكورسات
        $courses = Course::all();

        // ترجع View مع كل الداتا
        return view('home', [
            'user' => $user,
            'courses' => $courses
        ]);
    }
}
