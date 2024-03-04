<?php

namespace App\Http\Controllers;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address'=>'required|string',
            
        ]);
    
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 403);
          }

        $vendor = Vendor::create([
            'name' => $request->name,
            'address'=>$request->address,
            
        ]);
    
        return response()->json(['message' => 'Vendor created successfully', 'data' => $vendor], 201);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address'=>'required|string',
            
        ]);
        
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 403);
          }
         
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
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 403);
          }    


        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'vendor_id'=>$request->vendor_id
            
        ]);

        return response()->json(['message' => 'Product added successfully', 'data' => $product], 201);
    }

    public function editProduct(Request $request, Product $product)
    {
    
        if(!$product){
            abort(404, 'Product not found');
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

        if(!$productFound){
            return response()->json(['message' => 'Product not found']);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
        
    }

    public function addStock(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
           
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 403);
          } 

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
