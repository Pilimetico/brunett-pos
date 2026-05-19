<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::firstOrCreate(['name' => 'General']);
        
        Product::updateOrCreate(
            ['code' => 'PROD-001'],
            [
                'name' => 'Camiseta Brunett Premium',
                'category_id' => $cat->id,
                'cost' => 10,
                'pvp1' => 25,
                'stock' => 0,
                'is_active' => true,
                'available_local' => true
            ]
        );

        Supplier::firstOrCreate(
            ['document_number' => '1793084323001'],
            ['name' => 'Textiles Ecuador', 'is_active' => true]
        );

        Customer::firstOrCreate(
            ['document_number' => '1712345678'],
            [
                'first_name' => 'Juan', 
                'last_name' => 'Perez', 
                'credit_limit' => 1000, 
                'type' => 'normal',
                'is_active' => true
            ]
        );
    }
}
