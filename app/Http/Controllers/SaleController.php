<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function ticket(Sale $sale)
    {
        $sale->load(['customer', 'items.product']);
        return view('sales.ticket', compact('sale'));
    }
}
