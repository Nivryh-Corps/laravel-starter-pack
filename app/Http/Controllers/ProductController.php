<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function validateRequest(Request $request)
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

    public function index()
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )
        ->take(5)
        ->get();

        $success = [
                'success' => true,
                'products' => $products
        ];
            
        return response()->json(
            $success,
            200
        );
    }


    public function store(Request $req){

        $validator = $this->validateRequest($req);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cannot create category',
                ],
                400
            );
        }

        $product = Product::create($req->all());

        $success = [
                'success' => true,
                'product' => $product
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function show(Product $product){
        $success = [
                'success' => true,
                'product' => $product
        ];

        return response()->json(
            $success,
            200
        );
    }

    public function update(Request $req, Product $product){
        $product->init($req);
        $product->save();

        $success = [
                'success' => true,
                'product' => $product
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function destroy(Request $req, $id, Product $product){
        $product->delete();

        $success = [
                'success' => true,
                'product' => "product is deleted"
            ];

        return response()->json(
            $success,
            204
        );
    }
}
