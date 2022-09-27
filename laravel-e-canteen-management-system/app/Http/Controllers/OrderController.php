<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('student_id', Auth::guard('student')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('order.index', compact('orders'));
    }
}
