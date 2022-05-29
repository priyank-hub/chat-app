<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\Message;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $room = Room::GENERAL;

        return Inertia::render('Home', [
            'test' => 'Test Page',
            'user' => Auth::user(),
            'users' => User::all(),
            'rooms' => Room::all(),
            'chatData' => [
                'messages' => Room::where('name', $room)->first()->messages()->with('user')->get(),
                'rooms' => Room::all(),
                'room' => Room::where('name', $room)->first(),
            ]
        ]);
    }
}
