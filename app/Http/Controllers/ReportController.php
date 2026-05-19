<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function salesReport(Request $request)
    {
        $from = $request->get('from', Carbon::today()->startOfMonth());
        $to = $request->get('to', Carbon::today()->endOfDay());
        
        $sales = Sale::with('customer', 'user')
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $summary = [
            'total' => $sales->sum('total'),
            'cost' => $sales->sum('cost_total'),
            'profit' => $sales->sum('total') - $sales->sum('cost_total'),
            'count' => $sales->count()
        ];

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.sales', compact('sales', 'from', 'to', 'summary'));
            return $pdf->download("reporte-ventas-{$from}-a-{$to}.pdf");
        }

        return view('reports.sales', compact('sales', 'from', 'to', 'summary'));
    }

    public function inventoryReport()
    {
        $products = Product::orderBy('name')->get();
        $totalCost = $products->sum(fn($p) => $p->cost * $p->stock);
        $totalValue = $products->sum(fn($p) => $p->pvp1 * $p->stock);
        
        return view('reports.inventory', compact('products', 'totalCost', 'totalValue'));
    }
}
