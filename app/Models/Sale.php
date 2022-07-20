<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use DB;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    static public function getSales()
    {
        $data = DB::table('sales')
            
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->join('details', 'sales.id', '=', 'details.sale_id')
            ->join('products', 'details.product_id', '=', 'products.id')
            ->selectRaw('
                details.id,
                sales.id as sal_id,
                products.id as product_id,
                users.name as client, 
                products.reference,
                products.name,
                details.unit_value,
                details.amount,
                details.total,
                (
                    SELECT SUM(details.total) FROM details WHERE details.sale_id = sales.id
                ) as total_invoce,
                sales.created_at,
                sales.updated_at')
                ->orderBy('details.id', 'ASC')
            ->get();
        return $data;
    }

}
