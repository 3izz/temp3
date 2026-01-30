<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // تأكد أنك استدعيت موديل Course

class AdminController extends Controller
{
    // صفحة إضافة منشور (مثال موجود عندك)
    public function addpost()
    {
        return view('admin.addpost');
    }

    public function coachDashboard()
    {
        return redirect()->route('coach.dashboard');
    }
}
