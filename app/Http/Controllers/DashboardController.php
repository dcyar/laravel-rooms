<?php

namespace App\Http\Controllers;

use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'rooms' => Room::query()
                ->with('owner:id,name')
                ->latest()
                ->get(),
        ]);
    }
}
