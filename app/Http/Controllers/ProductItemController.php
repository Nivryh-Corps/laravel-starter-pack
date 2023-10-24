<?php

namespace App\Http\Controllers;

use App\Models\ProductItem;
use Illuminate\Http\Request;

class ProductItemController extends Controller
{

    public function index()
    {
        $productItems = ProductItem::with('product')->get();

        $success = [
                'success' => true,
                'productItem' => $productItems
            ];
            
        return response()->json(
            $success,
            200
        );
    }


    public function store(Request $req){
        $productItem = ProductItem::create($req->input());

        $success = [
                'success' => true,
                'productItem' => $productItem
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function show(ProductItem $productItem){
        $success = [
                'success' => true,
                'productItem' => $productItem
            ];

        return response()->json(
            $success,
            200
        );
    }

    public function update(Request $req, ProductItem $productItem){
        $productItem->init($req);
        $productItem->save();

        $success = [
                'success' => true,
                'productItem' => $productItem
            ];

        return response()->json(
            $success,
            200
        );
    }
    
    public function destroy(Request $req, ProductItem $productItem){
        $productItem->delete();

        $success = [
                'success' => true,
                'productItem' => "productItem is deleted"
            ];

        return response()->json(
            $success,
            204
        );
    }
}
