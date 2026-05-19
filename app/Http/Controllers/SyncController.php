<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WooCommerceService;
use App\Models\Product;

class SyncController extends Controller
{
    protected $wooService;

    public function __construct(WooCommerceService $wooService)
    {
        $this->wooService = $wooService;
    }

    public function index()
    {
        return view('sync.index');
    }

    public function syncStock()
    {
        $products = Product::where('is_active', true)->where('available_online', true)->get();
        $synced = 0;
        
        foreach($products as $product) {
            try {
                $this->wooService->syncProduct($product);
                $synced++;
            } catch (\Exception $e) {
                // Log error for specific product
            }
        }

        return back()->with('success', "Stock sincronizado para {$synced} productos.");
    }

    public function fetchOrders()
    {
        try {
            $orders = $this->wooService->getOrders();
            // Logic to convert Woo orders into local sales or notifications
            return view('sync.orders', compact('orders'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al conectar con WooCommerce: ' . $e->getMessage());
        }
    }
}
