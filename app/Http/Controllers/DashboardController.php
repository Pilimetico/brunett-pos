<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Box;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 0. SEGURIDAD SUPERADMIN
        if (!auth()->user()->hasRole('Administrador') && !auth()->user()->hasPermissionTo('ver_dashboard')) {
            abort(403, 'ACCESO DENEGADO: El Dashboard contiene información sensible (costos, utilidad, ganancias) y es exclusivo para el Administrador Principal.');
        }

        // 1. FILTROS
        $from = $request->from ?? Carbon::today()->format('Y-m-d');
        $to = $request->to ?? Carbon::today()->format('Y-m-d');
        
        $salesQuery = Sale::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        
        // 2. RESUMEN GENERAL Y GANANCIAS
        $salesToday = $salesQuery->get();
        $totalVentas = $salesToday->sum('total');
        $totalCostos = $salesToday->sum('cost_total');
        $gananciaObtenida = $totalVentas - $totalCostos; // Utilidad Bruta
        $margenGeneral = $totalVentas > 0 ? ($gananciaObtenida / $totalVentas) * 100 : 0;
        
        $countVentas = $salesToday->count();
        $ticketPromedio = $countVentas > 0 ? $totalVentas / $countVentas : 0;
        
        // 3. GASTOS Y UTILIDAD NETA
        $expensesToday = \App\Models\Expense::whereBetween('expense_date', [$from, $to])->sum('amount');
        $utilidadNetaEstimada = $gananciaObtenida - $expensesToday;

        // Productos Vendidos
        $productosVendidos = \App\Models\SaleItem::whereIn('sale_id', $salesToday->pluck('id'))->sum('quantity');

        // 4. VENTAS POR CANAL
        $salesByChannel = [
            'local' => $salesToday->where('channel', 'local')->sum('total'),
            'whatsapp' => $salesToday->where('channel', 'whatsapp')->sum('total'),
            'online' => $salesToday->where('channel', 'online')->sum('total'),
        ];

        // 5. CAJA DEL DIA Y DINERO QUE SALIO
        $currentBox = Box::where('status', 'open')->first();
        $salidasCaja = \App\Models\BoxMovement::where('type', 'out')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('amount');

        // 6. METAS Y ACUMULADOS
        $metaDiaria = \App\Models\Setting::where('key', 'daily_goal')->value('value') ?? 1000;
        $metaAnual = \App\Models\Setting::where('key', 'annual_goal')->value('value') ?? 120000;
        
        $startOfYear = Carbon::now()->startOfYear();
        $totalVentasAnual = Sale::where('created_at', '>=', $startOfYear)->sum('total');
        $avanceDiario = $metaDiaria > 0 ? ($totalVentas / $metaDiaria) * 100 : 0;
        $avanceAnual = $metaAnual > 0 ? ($totalVentasAnual / $metaAnual) * 100 : 0;

        // 7. PEDIDOS PENDIENTES
        $pedidosPendientes = \App\Models\Order::whereNotIn('status', ['delivered', 'cancelled'])->count();

        // 8. ALERTAS PRINCIPALES
        $recentSales = Sale::with('customer')->orderBy('created_at', 'desc')->take(5)->get();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->take(5)->get();

        return view('dashboard', compact(
            'from', 'to',
            'totalVentas', 'totalCostos', 'gananciaObtenida', 'margenGeneral', 
            'utilidadNetaEstimada', 'expensesToday',
            'countVentas', 'productosVendidos', 'ticketPromedio',
            'currentBox', 'salidasCaja',
            'recentSales', 'lowStockProducts', 'pedidosPendientes',
            'totalVentasAnual', 'metaAnual', 'metaDiaria', 'avanceDiario', 'avanceAnual', 'salesByChannel'
        ));
    }
}
