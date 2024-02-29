<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            
            
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            
            
        ]);

        return response()->json(['message' => 'Product added successfully', 'data' => $product], 201);
    }

    public function editProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            
        
        ]);

        return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
