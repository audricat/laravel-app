<?php

namespace App\Http\Controllers;
use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'buyer_name' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'numeric',
            'mobile_number' => 'required|numeric'
        ]);


        Order::create($data);

        return redirect()->back();
    }
}
