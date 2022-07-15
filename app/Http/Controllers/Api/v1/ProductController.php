<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    public function products()
    {
        return Product::getProducts();
    }

    public function store(Request $request)
    {
        return Product::saveProduct($request);
    }

    public function show($id)
    {
        return Product::getProduct($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('name', 'reference', 'price', 'weight','category','stock');

        $validator = Validator::make($data, [
            'name' => 'required',
            'reference' => 'required|unique:products,reference,' . $id,
            'price'  => 'required|integer', 
            'weight'  => 'required|integer',
            'category'  => 'required',
            'stock'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $product = Product::FindOrFail($id);

            $product->update([
                'name' => $data['name'],
                'reference'  => $data['reference'],
                'price'  => $data['price'], 
                'weight'  => $data['weight'],
                'category'  => $data['category'],
                'stock'  =>  $data['stock']
            ]);

            return response()->json([
                'success' => true,
                'product' => $product,
                'message' => 'El producto ha sido actualizado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }

    public function delete($id)
    {
        return Product::deleteProduct($id);
    }
}
