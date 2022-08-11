<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'price',
        'weight',
        'category',
        'stock',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    static public function getProducts($request)
    {
        $products = Product::query();

        
        $perPage = 10;
        $page = $request->input('page', 1);;
        $total = $products->count();

        $result = $products->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            
            'total_pages' => ceil($total / $perPage),
            'data' => $result,
        ];
     
    }

    static public function getProduct($id)
    {
        try {

            $product = Product::FindOrFail($id);
            return response()->json([
                'success' => true,
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }

    static public function saveProduct($request)
    {
        $data = $request->only('name', 'reference', 'price', 'weight','category','stock');
        
        $validator = Validator::make($data, [

            'name' => 'required',
            'reference'  => 'required|unique:products',
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
            $product = Product::create([
                'name' => $data['name'],
                'reference'  => $data['reference'],
                'price'  => $data['price'], 
                'weight'  => $data['weight'],
                'category'  => $data['category'],
                'stock'  =>  $data['stock']
            ]);

            return response()->json([
                'success' => true,
                'user' => $product,
                'message' => 'El nuevo producto ha sido creado satisfactoriamente.'
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                $e
            ], 500);
        }
    }

    static public function deleteProduct($id)
    {
        try {

            $product = Product::FindOrFail($id);
            $product->delete();
            return response()->json([
                'success' => true,
                'product' => $product,
                'message' => 'El producto ha sido eliminado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }
}
