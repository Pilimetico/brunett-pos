<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

class StockService
{
    public static function move($productId, $quantity, $type, $reason, $referenceType = null, $referenceId = null, $warehouseId = null)
    {
        $product = Product::findOrFail($productId);
        $balanceBefore = $product->stock;

        if ($type === 'in') {
            $product->increment('stock', $quantity);
        } elseif ($type === 'out') {
            $product->decrement('stock', $quantity);
        }

        $balanceAfter = $product->stock;

        return StockMovement::create([
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
            'type' => $type,
            'reason' => $reason,
            'quantity' => $quantity,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'user_id' => Auth::id() ?? 1,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }
}
