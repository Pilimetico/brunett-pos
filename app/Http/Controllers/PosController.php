<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Box;
use App\Models\BoxMovement;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        if (!$query) return response()->json([]);

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%")
            ->orWhere('sku', 'LIKE', "%{$query}%")
            ->where('is_active', true)
            ->where('available_local', true)
            ->take(20)->get();

        return response()->json($products);
    }

    public function searchCustomers(Request $request)
    {
        $q = $request->q;
        if (!$q) return response()->json([]);

        $customers = Customer::where('first_name', 'like', "%$q%")
            ->orWhere('last_name', 'like', "%$q%")
            ->orWhere('document_number', 'like', "%$q%")
            ->where('is_active', true)
            ->take(10)->get();

        foreach ($customers as $customer) {
            if ($customer->type === 'socio_brunett' && $customer->membership_expires_at && \Carbon\Carbon::parse($customer->membership_expires_at)->isPast()) {
                $customer->type = 'normal';
                $customer->is_member_active = false;
            }
        }
        return response()->json($customers);
    }

    public function createCustomer(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'document_number' => 'nullable|unique:customers',
            'phone' => 'nullable',
            'type' => 'required'
        ]);

        $customer = Customer::create($data);
        return response()->json(['success' => true, 'customer' => $customer]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'payments' => 'required|array|min:1',
        ]);

        // Check if box is open
        $currentBox = Box::where('status', 'open')->first();
        if (!$currentBox) {
            return response()->json(['success' => false, 'message' => 'Debe abrir caja antes de vender.'], 403);
        }

        try {
            DB::beginTransaction();

            $totalVenta = 0;
            $costoTotal = 0;
            
            foreach($request->items as $item) {
                $totalVenta += ($item['unit_price'] * $item['quantity']);
                $product = Product::find($item['product_id']);
                $costoTotal += ($product->cost * $item['quantity']);
                
                // Stock check and deduction (Kardex)
                \App\Services\StockService::move($product->id, $item['quantity'], 'out', 'Venta POS');
            }

            // Calculation Logic: Prices INCLUDE IVA
            $ivaPercent = Setting::where('key', 'iva_percentage')->value('value') ?? 15;
            $divisor = 1 + ($ivaPercent / 100);
            $subtotal = $totalVenta / $divisor;
            $ivaAmount = $totalVenta - $subtotal;

            // Sequential Invoice
            $lastSaleId = Sale::max('id') ?? 0;
            $invoiceNumber = 'VN-' . str_pad($lastSaleId + 1, 6, '0', STR_PAD_LEFT);

            // Create Sale
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $request->customer_id,
                'user_id' => 1,
                'channel' => 'local',
                'status' => 'pagada',
                'subtotal' => $subtotal,
                'total' => $totalVenta,
                'cost_total' => $costoTotal,
                'notes' => 'Venta POS'
            ]);

            // Create Items
            foreach($request->items as $item) {
                $product = Product::find($item['product_id']);
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->code,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $product->cost,
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['unit_price'] * $item['quantity'],
                    'total' => $item['unit_price'] * $item['quantity'],
                    'price_level_applied' => $item['price_level']
                ]);
            }

            // Register Payments in Box (PDF 2 - Punto 13)
            foreach($request->payments as $payment) {
                if ($payment['method'] === 'credit') {
                    $customer = Customer::findOrFail($request->customer_id);
                    if ($customer->credit_used + $payment['amount'] > $customer->credit_limit) {
                        throw new \Exception('Límite de crédito excedido para este cliente.');
                    }
                    $customer->increment('credit_used', $payment['amount']);
                }

                BoxMovement::create([
                    'box_id' => $currentBox->id,
                    'user_id' => auth()->id() ?? 1,
                    'type' => $payment['method'] === 'credit' ? 'credit' : 'income',
                    'reason' => 'Venta ' . $invoiceNumber,
                    'person_involved' => $request->customer_name ?? 'Cliente',
                    'amount' => $payment['amount'],
                    'notes' => 'Método: ' . ($payment['method'] ?? 'Efectivo')
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Venta procesada con éxito',
                'invoice' => $invoiceNumber,
                'sale_id' => $sale->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
