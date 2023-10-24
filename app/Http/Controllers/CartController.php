<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function validateRequest(Request $request)
    {
        return Validator::make(
            $request->input(),
            [
                "sum_total" => 'required|number',
                "user_id" => "required|number"
            ]
        );
    }

    public function index()
    {
        $carts = Cart::leftJoin('users', 'carts.user_id', '=', 'users.id')->select('sum_total', 'carts.id', 'name', 'paid_flag')->get();
        
        $success = [
                'success' => true,
                'cart' => $carts
            ];
            
        return response()->json(
            $success,
            200
        );
    }


    public function store(Request $req){
        $cart = Cart::create($req->input());

        $success = [
                'success' => true,
                'cart' => $cart
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function show($id){

        $cart = Cart::join('users', 'users.id', '=', 'carts.user_id')->select('carts.id', 'sum_total', 'paid_flag', 'name')->find($id);
        $items = ProductItem::leftJoin('products', 'products.id', '=', 'product_items.product_id')->where('cart_id', '=', $id)->select('product_name', 'product_price', 'quantity')->get();
        //$test = $cart->products()->getRelated()->get();

        $success = [
                'success' => true,
                'cart' => $cart,
                'items' => $items
            ];

        return response()->json(
            $success,
            200
        );
    }

    public function update(Request $req, Cart $cart){
        $cart->update($req->input());

        $success = [
                'success' => true,
                'cart' => $cart
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function destroy(Request $req, Cart $cart){
        $cart->delete();

        $success = [
                'success' => true,
                'cart' => "cart is deleted"
            ];

        return response()->json(
            $success,
            204
        );
    }
}
