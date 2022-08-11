<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Buy extends Model
{
    use HasFactory;

    public static function getShopping()
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
                ->orderBy('id','DESC')
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
                    'id' => $arg->id,
                    'client' => $arg->client,
                    'total_invoice' => '$' . $arg->total_invoce,
                    'date_invoice' => $arg->created_at,
                    'date_updated' => $arg->updated_at
                ];
            }

            $invoce =   $arg->id;
        }

        return array_slice($tmp,false);
    }
}
