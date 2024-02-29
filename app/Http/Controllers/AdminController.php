<?php

namespace App\Http\Controllers;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address'=>'required|string',
            
        ]);
    
        
        $vendor = Vendor::create([
            'name' => $request->name,
            'address'=>$request->address,
            
        ]);
    
        return response()->json(['message' => 'Vendor created successfully', 'data' => $vendor], 201);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address'=>'required|string',
            
        ]);
         
        $vendorFind=Vendor::find($vendor);

        if(!$vendorFind){
            return response()->json(['message' => 'Vendor not found']);
           
        }else{
            $vendor->update([
                'name' => $request->name,
                'address'=>$request->address,
            ]);

            return response()->json(['message' => 'Vendor updated successfully', 'data' => $vendor]);
           
        }
        
    }

    public function destroy(Vendor $vendor)
    {
        $vendorFind=Vendor::find($vendor);

        if($vendorFind)
        {
            return response()->json(['message' => 'Vendor not found']); 
        }
            $vendor->delete();
            return response()->json(['message' => 'Vendor deleted successfully']);
     
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor_id'=>'required'
            
            
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'vendor_id'=>$request->vendor_id
            
        ]);

        return response()->json(['message' => 'Product added successfully', 'data' => $product], 201);
    }

    public function editProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
    
        try {
            $productFound = Product::findOrFail($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
    
        return response()->json(['message' => 'Product updated successfully', 'data' => $productFound]);
    }
    

    public function deleteProduct(Product $product)
    {
        $productFound=Product::find($product);

        dd($productFound);

        if(!$productFound){
            return response()->json(['message' => 'Product not found']);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
        
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
           
        ]);

        $stock = Stock::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            
        ]);

        return response()->json(['message' => 'Stock added successfully', 'data' => $stock], 201);
    }

    public function editStock(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            
        ]);

        $stock->update([
            'quantity' => $request->quantity,
            
        ]);

        return response()->json(['message' => 'Stock updated successfully', 'data' => $stock]);
    }

    public function deleteStock(Stock $stock)
    {
        $stock->delete();

        return response()->json(['message' => 'Stock deleted successfully']);
    }

}
