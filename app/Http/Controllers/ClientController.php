<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function homepage(Request $request)
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )->limit(5);

        $categories = Category::query()->get()->limit(5);
    }

    public function productspage(Request $request)
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )->paginate(12);

        $categories = Category::all(['name']);
    }

    public function productspage_search_id(Request $request, $id)
    {
        $products = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )->find($id);

        $categories = Category::all(['name']);
    }


    public function cartpage(Request $request)
    {

    }

    public function detailpage(Request $request, $id)
    {
        $product = Product::select(
            "product_name",
            "product_price",
            "product_description",
            "discount"
        )->find($id);
    }
}
