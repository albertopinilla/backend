<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Product;
use Carbon\Carbon;

class BuyController extends Controller
{
    public function shopping()
    {
        $data = DB::table('sales')
            ->where('user_id', auth()->user()->id)
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->join('details', 'sales.id', '=', 'details.sale_id')
            ->join('products', 'details.product_id', '=', 'products.id')
            ->selectRaw('sales.id,users.name as client, products.reference,products.name,details.unit_value,details.amount,details.total,
                (
                    SELECT SUM(details.total) FROM details WHERE details.sale_id = sales.id
                ) as total_invoce,
                sales.created_at')
            ->get();

        $tmp = [];

        $invoce = null;

        foreach ($data as $key => $arg) {

            $tmp[$arg->id]['items'][] = [
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
                    'date' => $arg->created_at
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
                'message' => 'No se han registrado compras.',
            ], 200);
        }
    }

    public function buy(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '*.product_id' => 'required|integer|not_in:0|regex:/^\d+$/',
            '*.amount' => 'required|integer|not_in:0|regex:/^\d+$/|regex:/^[0-9]+$/',

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

        foreach ($request->all() as $key => $value) {

            $data[] = $value;
            $data[$key]['sale_id'] = $sal_id;

            $unit_value = $this->getPrice($value['product_id']);

            $data[$key]['unit_value'] = $unit_value;
            $data[$key]['total'] = ($unit_value * $value['amount']);
        }

        DB::table('details')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'La compra ha sido realizada satisfactoriamente.'
        ], 422);
    }

    public function getPrice($id)
    {
        $price = DB::table('products')->where('id', $id)->value('price');
        return $price;
    }

    // Valida el stock del producto
    public function validateStock($id, $amount): bool
    {
        if (Product::where('id', $id)->where('stock', '>=', $amount)->exists()) {
            return true;
        } else {
            return false;
        }
    }
}
