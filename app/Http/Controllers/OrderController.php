<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{

    public function order(Request $request)
    {
        $validator = \Validator::make($request->all(), [ 
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $product = Product::find($product_id);
        
        if(empty($product)){
            return response()->json([
                'message' => 'Product Not Found'
            ], 400);
        }

        if($product->stock == 0 || $product->stock < $quantity){
            return response()->json([
                'message' => 'Failed to order this product due to unavailability of the stock.'
            ], 400);
        }

        $product->stock = $product->stock - $quantity;
        $product->save();

        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);

        return response()->json([
            'message' => 'You have successfully ordered this product.'
        ], 201);
    }
}
