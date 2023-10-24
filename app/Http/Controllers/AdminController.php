<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function homepage()
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )
        ->take(5)
        ->get();

        $carts = Cart::with('user')->get();

        
    }

    public function productspage(Request $request)
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )->paginate(12);


    }

    public function addproduct(Request $request)
    {
        if ($request->method() == "POST") {
            $model_valid = new ValidatorModel();
            $validator = $model_valid->validateProduct($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cannot create Product',
                    ],
                    400
                );
            }
            $product = Product::create($request->input());
        }

       
    }

    public function productdetailpage(Request $request, $id)
    {
        $product = Product::find($id);
        $model_valid = new ValidatorModel();
        $validator = $model_valid->validateProduct($request);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cannot create User',
                ],
                400
            );
        }
        if ($request->method() === "PUT" || $request->method() === "PATCH") {
            $product->update($request->input());
        }

        if ($request->method() == "DELETE") {
            $product->delete();
        }
    }

    public function categoriespage(Request $request)
    {
        if ($request->method() == "POST") {
            $model_valid = new ValidatorModel();
            $validator = $model_valid->validateCategory($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cannot create Category',
                    ],
                    400
                );
            }
            $category = Category::create($request->input());
        }

        $categories = Category::all(['name']);
        
    }

    public function categorydetailpage(Request $request, $id)
    {
        $model_valid = new ValidatorModel();
        $validator = $model_valid->validateCategory($request);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cannot create User',
                ],
                400
            );
        }

        $category = Category::find($id);

        if ($request->method() === "PUT" || $request->method() === "PATCH") {
            $category->update($request->all());
        }

        if ($request->method() == "DELETE") {
            $category->delete();
        }
    }

    public function cartspage(Request $request)
    {
        $carts = Cart::all();
        
    }

    public function cartdetailpage(Request $request, $id)
    {
        $cart = Cart::with('user', 'products.product')->find($id);
        $products = array();
        $sum = 0;
        foreach($cart->products as $prod){
            $pro = array();
            $pro["quantity"] = $prod->quantity;
            $pro["name"] = $prod->product->product_name;
            $pro["price"] = $prod->product->product_price;
            $products[$prod->id]= $pro;
            $sum += ($prod->product->product_price * $prod->quantity);
        }
        
    }

    public function userspage(Request $request)
    {
        if ($request->method() == "POST") {
            $model_valid = new ValidatorModel();
            $validator = $model_valid->validateUser($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cannot create User',
                    ],
                    400
                );
            }
            $user = User::create($request->all());
        }

        $users = User::all(['name']);
    }

    public function userdetailpage(Request $request, $id)
    {
        $model_valid = new ValidatorModel();
        $validator = $model_valid->validateUser($request);

        $user = User::find($id);

        if ($request->method() === "PUT" || $request->method() === "PATCH") {
            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cannot create User',
                    ],
                    400
                );
            }
            $user->update($request->all());
        }

        if ($request->method() == "DELETE") {
            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cannot create User',
                    ],
                    400
                );
            }
            $user->delete();
        }

    }
}

class ValidatorModel {
    public function validateProduct(Request $request)
    {
        return Validator::make(
            $request->all(),
            [
                "product_name" => 'required|string',
                "product_price" => 'required|numeric',
                "product_description" => 'nullable|string',
                "discount" => 'required|numeric',
            ]
        );
    }

    public function validateUser(Request $request)
	{
		return Validator::make(
			$request->all(),
			[
				"name" => 'required|string',
                "email" => 'required|email|unique:users',
                "password" => 'required|string',
			]
		);
	}

    public function validateCart(Request $request)
    {
        return Validator::make(
            $request->all(),
            [
                "sum_total" => 'required|numeric',
                "user_id" => "required|numeric"
            ]
        );
    }

    public function validateCategory(Request $request)
    {
        return Validator::make(
            $request->all(),
            [
                "name" => 'required|string',
            ]
        );
    }
}