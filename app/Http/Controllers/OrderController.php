<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
     public function print($id)
    {
        $order = Order::with('customer')->findOrFail($id);

        return view('orders.print', compact('order'));
    }
}
