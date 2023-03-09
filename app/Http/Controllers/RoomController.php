<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('rooms.index', [
            'rooms' => Room::query()
                ->withCount('members')
                ->where('owner_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('rooms.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $room = Room::query()->create([
            'name' => $validated['name'],
            'owner_id' => auth()->id(),
        ]);

        $room->members()->attach(auth()->id());

        return to_route('rooms.index');
    }

    public function show(Room $room)
    {
        $room->load([
            'messages' => fn ($query) => $query->with('user')->latest(),
            'members',
        ]);

        return view('rooms.show', compact('room'));
    }

    public function join(Room $room)
    {
        $room->members()->attach(auth()->id());

        return to_route('rooms.show', $room);
    }
}
