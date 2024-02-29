<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{

    public function register(Request $request)
    {
        $validator=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'=>'required'
        ]);
        //dd($validator);
    

        $user = User::create([
            'role_id'=> $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
           
        ]);
       
        
        return response()->json(['message' => 'Customer registered successfully', 'data' => $user], 201);
      
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            
            return response()->json(["User loged In"], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function productList()
    {
        $products = Product::all();

        return response()->json(['products' => $products], 200);
    }
}
