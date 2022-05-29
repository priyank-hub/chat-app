<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Room;
use App\Events\ChatEvent;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('chat.chat');
    }

    public function renderChat(Room $room)
    {
        $rooms = Room::all()->pluck('name')->toArray();

        // if ($room === Room::GENERAL) return redirect()->route('chat');

        // if (!$room) $room = Room::GENERAL;
        
        return Inertia::render('ChatBox', [
            'chatData' => [
                'messages' => $room->messages()->with('user')->get(),
                'rooms' => $rooms,
                'room' => $room
            ],
            'user' => Auth::user(),
        ]);
    }

    public function sendMessage(Request $request, Room $room)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user();
        $message = $user->messages()->create([
            'message' => $request->message,
            'room_id' => $room->id
        ]);

    	broadcast(new ChatEvent($user, $room, $message))->toOthers();

    	return ['status' => 'success'];
    }
}
