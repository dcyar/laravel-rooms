<?php

namespace App\Http\Controllers;

use App\Events\NewThingAvailable;
use App\Events\OrderDispatched;
use App\Models\Order;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index()
    {
        return view('broadcast');
    }

    public function store(Request $request)
    {
        NewThingAvailable::dispatch($request->string('message'));

        return to_route('broad');
    }

    public function private()
    {
        OrderDispatched::dispatch(Order::find(1));
    }
}
