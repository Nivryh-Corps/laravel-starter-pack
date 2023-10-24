<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register(Request $request)
	{
		try {

			$validator = $this->validateRequest($request);

			if ($validator->fails()) {
				return response()->json(
					[
						'success' => false,
						'message' => 'Cannot create User',
					],
					400
				);
			}

			/* if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
				return redirect()->back()->withErrors(['message' => 'Un utilisateur utilise ce nom']);
			} public function initModel(Request $req){
        $this->name = $req->input('name');
        $this->password = $req->input('password');
        $this->number = $req->input('number');
    }*/

			$user = User::create($request->all());
			$user->password = Hash::make($request->input('password'));
			$user->save();

			Session::put('user', $user->id);

			return response()->json(
                [
                    'success' => true,
                    'token' => $token,
					'name' => $user->name,
					'user' => $user->id
                ],
                201
            );
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(['message' => '' .$e]);
		}
	}

	public function update(Request $request, $id)
	{
		try {

			$validator = $this->validateRequest($request);

			if ($validator->fails()) {
				return response()->json(
					[
						'success' => false,
						'message' => 'Cannot create User',
					],
					400
				);
			}

			$user = User::query()->where('id', '=', $id)->get()->first();
			$user->name = $request->input('name');
			$user->email = $request->input('email');
			if ($request->input('password') != '') {
				$user->password = Hash::make($request->input('password'));
			}
			$user->save();

			return response()->json(
                [
                    'success' => true,
                    'token' => $token,
					'name' => $user->name,
					'user' => $user->id
                ],
                201
            );
			//return redirect()->back();
		} catch (\Exception $e) {
			return response()->json(
				[
					'success' => false,
					'message' => 'Cannot create Item',
				],
				400
			);
		}
	}

	public function login(Request $request)
	{
		try {

			$validator = $this->validateRequest($request);

			if ($validator->fails()) {
				return response()->json(
					[
						'success' => false,
						'message' => $request,
					],
					400
				);
			}



			if (Auth::attempt(['name' => $request->name, 'password' => $request->password]) || Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
				$auth = Auth::user();
				$auth->tokens()->delete();
				$token = $auth->createToken('shop_key')->plainTextToken;
				Session::put('user', $auth->id);


				return redirect('/profile');
			} else {
				return redirect()->back()->with('message', ['Utilisateur avec le meme nom']);
			}
		} catch (\Exception $e) {
			return response()->json(
				[
					'success' => false,
					'message' => '',
				],
				400
			);
		}
	}

	public function validateRequest(Request $request)
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
}