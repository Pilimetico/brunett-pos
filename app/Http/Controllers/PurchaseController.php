<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->orderBy('created_at', 'desc')->paginate(15);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::orderBy('name')->get();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'invoice_number' => 'required',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => $request->invoice_number,
                'purchase_date' => $request->purchase_date,
                'total' => 0,
                'status' => 'received',
                'notes' => $request->notes,
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $purchaseItem = PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total' => $item['quantity'] * $item['unit_cost'],
                ]);

                $total += $purchaseItem->total;

                // Update product stock and last cost (Kardex)
                $product = Product::find($item['product_id']);
                \App\Services\StockService::move($product->id, $item['quantity'], 'in', 'Compra', 'Purchase', $purchase->id);
                $product->cost = $item['unit_cost'];
                $product->save();
            }

            $purchase->update(['total' => $total]);

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Compra registrada e inventario actualizado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
