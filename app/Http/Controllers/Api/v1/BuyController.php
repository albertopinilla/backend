<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Validator;
use App\Models\{Product, Sale};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BuyController extends Controller
{
    public function shopping()
    {
        $data = DB::table('sales')
            ->where('user_id', auth()->user()->id)
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->join('details', 'sales.id', '=', 'details.sale_id')
            ->join('products', 'details.product_id', '=', 'products.id')
            ->selectRaw('sales.id,products.id as product_id,users.name as client, products.reference,products.name,details.unit_value,details.amount,details.total,
                (
                    SELECT SUM(details.total) FROM details WHERE details.sale_id = sales.id
                ) as total_invoce,
                sales.created_at,
                sales.updated_at')
            ->get();

        $tmp = [];

        $invoce = null;

        foreach ($data as $key => $arg) {

            $tmp[$arg->id]['items'][] = [
                'id' => $arg->product_id,
                'reference' => $arg->reference,
                'name' => $arg->name,
                'amount' => $arg->amount,
                'unit_value' => '$' . $arg->unit_value,
                'total' => '$' . $arg->total,
            ];

            if ($invoce != $arg->id || $invoce == null) {

                $tmp[$arg->id]['resume'] = [
                    'client' => $arg->client,
                    'total_invoice' => '$' . $arg->total_invoce,
                    'date_invoice' => $arg->created_at,
                    'date_updated' => $arg->updated_at
                ];
            }

            $invoce =   $arg->id;
        }

        if (count($tmp) > 0) {
            return response()->json([
                'shopping' => $tmp,
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se han realizado compras.',
            ], 200);
        }
    }

    public function buy(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '*.product_id' => 'required|integer|not_in:0|regex:/^\d+$/',
            '*.amount' => 'required|integer|not_in:0|regex:/^\d+$/|regex:/^[0-9]+$/'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        foreach ($request->all() as $key => $value) {

            try {
                $product_id = Product::FindOrFail($value['product_id']);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'El id del producto seleccionado no existe.',
                    'error' => $e->getMessage()
                ], 404);
            }

            if (!$this->validateStock($product_id->id, $value['amount'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad seleccionada es mayor al stock del producto, no es posible hacer la compra.'
                ], 422);
            }
        }

        $sal_id = DB::table('sales')->insertGetId([
            'user_id' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $data = [];

        $this->registerBuy($request->all(), $sal_id);

        return response()->json([
            'success' => true,
            'message' => 'La compra ha sido realizada satisfactoriamente.'
        ], 422);
    }

    public function update(Request $request, $id)
    {

        // Validación de request
        $validator = Validator::make($request->all(), [
            '*.product_id' => 'required|integer|not_in:0|regex:/^\d+$/',
            '*.amount' => 'required|integer|not_in:0|regex:/^\d+$/|regex:/^[0-9]+$/',
        ]);

        // Mostrar errores de validación
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Valida que el usuario logueado halla realizado la compra
        if (!$this->userPurchase($id)) {
            return response()->json([
                'message' => 'El usuario autenticado no ha realizado esta compra.',
            ], 404);
        }

        // Valida que en el request no vengan ID de productos repetidos
        $test = collect($request->all());
        
        $t = $test->duplicates('product_id');

        if(count($t) > 0)
        {
            return response()->json([
                'message' => 'El ID del producto se encuentra más de una vez',
            ], 404);
        }
        

        // Validación de la existencia del ID de la compra
        try {
            Sale::FindOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'El id de la compra seleccionada no existe.',
                'error' => $e->getMessage()
            ], 404);
        }

        // Retorna los productos de la compra actual
        $shopping_old = DB::table('details')
            ->where('sale_id', $id)
            ->get();

        $data = [];

        // Validación de existencia de producto y disponibilidad de stock de compra anterior
        foreach ($request->all() as $key => $value) {
            
            try {
                $product_id = Product::FindOrFail($value['product_id']);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'El id '.$value['product_id'].' del producto seleccionado no existe.',
                    'error' => $e->getMessage()
                ], 404);
            }

            foreach ($shopping_old as $k => $val) {
                
                if ($value['product_id'] === $val->product_id) {
                    $data[] = $val->product_id;
                 
                    if (!$this->validateStock($product_id->id, ($value['amount'] - $val->amount))) {

                        return response()->json([
                            'success' => false,
                            'message' => 'La cantidad seleccionada del producto ID '.$val->product_id.' es mayor al stock del producto, no es posible hacer la compra.'
                        ], 422);
                    }
                }
            }
        }

        // Validación de existencia de producto y disponibilidad de stock de compra anterior
        $collection = collect($request->all());
        
        $new = $collection->whereNotIn('product_id', $data);
        
        foreach ($new  as $key => $value) {
            
            if (!$this->validateStock($value['product_id'], ($value['amount']))) {

                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad seleccionada del producto ID '.$value['product_id'].' es mayor al stock del producto, no es posible hacer la compra.'
                ], 422);
            }
        }
      
        // Devuelve los productos de la compra anterior al stock
        $this->returnStock($id);

        // Crear la compra nuevamente 
        $this->registerBuy($request->all(), $id);

        // Actualización de fecha de edición de una venta
        DB::table('sales')->where('id',$id)
            ->update([
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);


        return response()->json([
            'success' => true,
            'message' => 'La compra ha sido actualizada satisfactoriamente.'
        ], 200);
    }

    private function registerBuy($items, $id)
    {
        $data = [];

        foreach ($items as $key => $value) {

            $data[$key]['product_id'] = $value['product_id'];
            $data[$key]['sale_id'] = $id;
            $data[$key]['amount'] = $value['amount'];
            $unit_value = $this->getPrice($value['product_id']);
            $data[$key]['unit_value'] = $unit_value;
            $data[$key]['total'] = ($unit_value * $value['amount']);

            $this->discountStock($value['product_id'], $value['amount']);
        }

        DB::table('details')->insert($data);
    }

    // Retorna los productos de una compra a su Stock
    private function returnStock($id)
    {

        $products = DB::table('details')
            ->where('sale_id', $id)
            ->get();

        foreach ($products as $key => $value) {
            //return "id ".$value->product_id. " stock ".$value->amount;
            DB::table('products')
                ->where('id', $value->product_id)
                ->increment('stock', $value->amount);
        }

        DB::table('details')
            ->where('sale_id', $id)
            ->delete();
    }

    // Valida que la compra halla sido hecha por el usuario autenticado
    private function userPurchase($id)
    {
        if (
            DB::table('sales')->where('user_id', auth()->user()->id)
            ->where('sales.id', $id)
            ->join('details', 'sales.id', '=', 'details.sale_id')
            ->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    // Descuenta una cantidad del stock
    private function discountStock($id, $amount)
    {
        DB::table('products')
            ->where('id', $id)
            ->decrement('stock', $amount);

        $this->validateStockBuy($id);
    }

    private function validateStockBuy($id)
    {
        $data = DB::table('products')
            ->where('id', $id)->value('stock');

        if($data <= 5)
        {
            Log::debug('Cantidad del producto menor a 5');
        }    
    }

    // Devuelve el precio de un producto
    private function getPrice($id)
    {
        $price = DB::table('products')->where('id', $id)->value('price');
        return $price;
    }

    // Valida el stock del producto
    private function validateStock($id, $amount): bool
    {
        if (Product::where('id', $id)->where('stock', '>=', $amount)->exists()) {
            return true;
        } else {
            return false;
        }
    }
}
