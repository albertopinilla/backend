<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class ProductController extends Controller
{
    public function products(Request $request)
    {
        return Product::getProducts($request);
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

        $integer = 'required|integer';

        $validator = Validator::make($data, [
            'name' => 'required',
            'reference' => 'required|unique:products,reference,' . $id,
            'price'  => $integer, 
            'weight'  => $integer,
            'category'  => 'required',
            'stock'  => $integer,
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
