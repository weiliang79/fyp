<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('checkout.index', compact('order'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment' => 'required',
        ]);

        dd($request);
    }
}
