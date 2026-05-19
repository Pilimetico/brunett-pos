<?php

namespace App\Services;

use Automattic\WooCommerce\Client;

class WooCommerceService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.woocommerce.url'),
            config('services.woocommerce.key'),
            config('services.woocommerce.secret'),
            [
                'version' => 'wc/v3',
                'verify_ssl' => false, // Set to true in production with valid SSL
            ]
        );
    }

    public function getOrders()
    {
        return $this->client->get('orders', ['status' => 'processing']);
    }

    public function updateProductStock($wooId, $quantity)
    {
        $data = [
            'manage_stock' => true,
            'stock_quantity' => $quantity
        ];

        return $this->client->put("products/{$wooId}", $data);
    }

    public function syncProduct($product)
    {
        // Search product by SKU in WooCommerce
        $wooProducts = $this->client->get('products', ['sku' => $product->code]);
        
        if (!empty($wooProducts)) {
            $wooId = $wooProducts[0]->id;
            // Update stock and price
            return $this->updateProductStock($wooId, $product->stock);
        }
        
        return null;
    }
}
