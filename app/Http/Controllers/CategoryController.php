<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function validateRequest(Request $request)
    {
        return Validator::make(
            $request->all(),
            [
                "name" => 'required|string',
            ]
        );
    }

    public function index()
    {
        $categorys = Category::all(['name']);

        $success = [
            'success' => true,
            'categories' => $categorys
        ];

        return response()->json(
            $success,
            200
        );
    }


    public function store(Request $req)
    {
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

        $category = Category::create($req->all());

        $success = [
            'success' => true,
            'category' => $category
        ];

        return response()->json(
            $success,
            200
        );
    }

    public function show(Category $category)
    {
        $success = [
            'success' => true,
            'category' => $category
        ];

        return response()->json(
            $success,
            200
        );
    }

    public function update(Request $req, Category $category)
    {
        $category->init($req);
        $category->save();

        $success = [
            'success' => true,
            'category' => $category
        ];

        return response()->json(
            $success,
            200
        );
    }

    public function destroy(Request $req, $id, Category $category)
    {
        $category->delete();

        $success = [
            'success' => true,
            'category' => "category is deleted"
        ];

        return response()->json(
            $success,
            204
        );
    }
}
