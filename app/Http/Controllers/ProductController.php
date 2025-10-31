<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('prod_deleted', 0)->paginate(10);
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999',
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $product = Product::create([
                'prod_name' => $validated['name'],
                'prod_description' => $validated['description'],
                'prod_price' => $validated['price'],
                'prod_quantity' => $validated['quantity'],
            ]);

            return response()->json([
                'message' => 'Product added successfully.',
                'product' => $product
            ], 201);

        } catch (QueryException $e) {
            // Other database errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            // Catch any other errors
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = Product::where('prod_deleted', 0)->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json($product);
        } catch (\Exception $e) {
            // Catch any other errors
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::where('prod_deleted', 0)->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'price' => 'required|numeric|min:0|max:99999999',
                'quantity' => 'required|numeric|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $product->prod_name = $validated['name'];
            $product->prod_description = $validated['description'];
            $product->prod_price = $validated['price'];
            $product->prod_quantity = $validated['quantity'];
            $product->save();

            return response()->json([
                'message' => 'Product updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Catch any other errors
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::where('prod_deleted', 0)->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $product->prod_deleted = 1;
            $product->save();

            return response()->json([
                'message' => 'Product deleted successfully.'
            ]);
        } catch (\Exception $e) {
            // Catch any other errors
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
