<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->paginate(15);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'customer');
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_id' => $request->customer_id,
                'channel' => 'whatsapp',
                'status' => 'created',
                'total' => 0,
                'notes' => $request->notes,
                'shipping_address' => $request->shipping_address,
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $total += $orderItem->quantity * $orderItem->price;

                // RESERVE stock
                $product->stock -= $item['quantity'];
                $product->save();
            }

            $order->update(['total' => $total]);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pedido de WhatsApp registrado y stock reservado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        // Si el pedido pasa a pagado, registrar como Venta oficial para que sume al Dashboard
        if ($request->status === 'pagado') {
            $invoiceNumber = 'WAPP-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            
            // Verificar si ya existe para no duplicar
            $existingSale = \App\Models\Sale::where('invoice_number', $invoiceNumber)->first();
            
            if (!$existingSale) {
                // Calcular costo total
                $costTotal = 0;
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $costTotal += $product->cost * $item->quantity;
                    }
                }

                $sale = \App\Models\Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $order->customer_id,
                    'user_id' => auth()->id(),
                    'channel' => 'whatsapp',
                    'status' => 'pagada',
                    'subtotal' => $order->total,
                    'total' => $order->total,
                    'cost_total' => $costTotal,
                    'notes' => 'Venta proveniente de Pedido WhatsApp #' . $order->id,
                    'created_at' => now(),
                ]);

                // Crear los items de la venta
                foreach ($order->items as $item) {
                    $product = \App\Models\Product::find($item->product_id);
                    \App\Models\SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item->product_id,
                        'product_name' => $product ? $product->name : 'Desconocido',
                        'product_sku' => $product ? $product->sku : '',
                        'quantity' => $item->quantity,
                        'unit_cost' => $product ? $product->cost : 0,
                        'unit_price' => $item->price,
                        'subtotal' => $item->quantity * $item->price,
                        'total' => $item->quantity * $item->price
                    ]);
                }
            }
        }

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}
