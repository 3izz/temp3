<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $authUser = auth()->user();

        $conversations = User::query()
            ->where('id', '!=', $authUser->id)
            ->where(function ($q) use ($authUser) {
                // If auth user is a regular user, show only coaches
                if ($authUser->role === 'user') {
                    $q->where('role', 'coach');
                }
                // If auth user is a coach, show only regular users
                elseif ($authUser->role === 'coach') {
                    $q->where('role', 'user');
                }
                // If admin, show both (optional)
            })
            ->orderBy('name')
            ->get(['id', 'name', 'role', 'profile_photo']);

        return view('chat.index', compact('conversations'));
    }
}
