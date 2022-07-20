<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function sales()
    {
        $sales = Sale::getSales();

        return response()->json([
            'success' => true,
            'products' => $sales
        ], 200);
    }
    
}
