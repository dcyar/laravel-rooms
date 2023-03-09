<?php

namespace App\Http\Controllers;

use App\Events\RoomMessageSent;
use App\Models\RoomMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', Rule::exists('rooms', 'id')],
            'message' => ['required', 'string'],
        ]);

        $roomMessage = RoomMessage::query()
            ->create([
                ...$validated,
                'user_id' => auth()->id(),
            ]);

        $roomMessage->load('user');
        broadcast(new RoomMessageSent($roomMessage))->toOthers();
        // RoomMessageSent::dispatch($roomMessage);

        return response()->json([
            'message' => 'message was send successfully',
            'data' => $roomMessage,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
