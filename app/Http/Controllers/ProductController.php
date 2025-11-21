<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     // Get all products
        public function index()
    {
        return Product::all();
    } // end index


    // Create product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

      $status = $request->stock == 0 ? 'out_of_stock' : 'in_stock';

      $product =   Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $status
      ]);

        return response()->json([
             'message' => 'Product created successfully' ,
            'product' => $product,

        ], 201);
    } // end store


    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer|min:0',
        ]);

          $product->update($request->all());

        // Apply business rule
        if ($product->stock == 0) {
            $product->status = 'out_of_stock';
        } else {
            $product->status = 'in_stock';
        }

        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    } // end update


    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    } // end destroy

}
