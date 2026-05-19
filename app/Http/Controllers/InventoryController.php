<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function kardex(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->product_id, function($q) use ($request) {
                return $q->where('product_id', $request->product_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('inventory.kardex', compact('movements', 'products'));
    }

    public function adjustments()
    {
        $products = Product::orderBy('name')->get();
        return view('inventory.adjustments', compact('products'));
    }

    public function transfers()
    {
        $products = Product::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::all();
        return view('inventory.transfers', compact('products', 'warehouses'));
    }

    public function storeTransfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'quantity' => 'required|numeric|min:0.01'
        ]);

        \App\Services\StockService::move(
            $request->product_id, 
            $request->quantity, 
            'out', 
            'Transferencia a ' . $request->to_warehouse_id,
            null, null,
            $request->from_warehouse_id
        );

        \App\Services\StockService::move(
            $request->product_id, 
            $request->quantity, 
            'in', 
            'Transferencia desde ' . $request->from_warehouse_id,
            null, null,
            $request->to_warehouse_id
        );

        return back()->with('success', 'Transferencia entre bodegas completada.');
    }

    public function storeAdjustment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'reason' => 'required'
        ]);

        \App\Services\StockService::move(
            $request->product_id, 
            $request->quantity, 
            $request->type, 
            'Ajuste: ' . $request->reason
        );

        return back()->with('success', 'Ajuste de inventario registrado correctamente.');
    }
}
