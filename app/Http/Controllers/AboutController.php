<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // جلب كل المستخدمين الذين لديهم دور 'coach' أو 'teacher'
        $coaches = User::where('role', 'coach')
            ->orWhere('role', 'teacher')
            ->orWhere('role', 'instructor')
            ->get()
            ->map(function ($coach) {
                return [
                    'id' => $coach->id,
                    'name' => $coach->name,
                    'email' => $coach->email,
                    'profile_photo' => $coach->profile_photo_url,
                    'role' => $coach->role,
                    'bio' => $coach->bio ?? 'Professional coach dedicated to helping students achieve their goals.',
                    'specialization' => $coach->specialization ?? 'Expert in various fields'
                ];
            });

        return view('about', compact('coaches'));
    }
}
