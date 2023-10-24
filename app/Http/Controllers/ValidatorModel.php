<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatorModel {
    public function validateProduct(Request $request)
    {
        return Validator::make(
            $request->all(),
            [
                "product_name" => 'required|string',
                "product_price" => 'required|number',
                "product_description" => 'nullable|string',
                "discount" => 'required|number',
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
                "sum_total" => 'required|number',
                "user_id" => "required|number"
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