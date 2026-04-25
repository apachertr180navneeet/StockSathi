<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\WareHouse;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transfer;
use App\Models\TransferItem;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Truncate tables to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        WareHouse::truncate();
        Supplier::truncate();
        Customer::truncate();
        ProductCategory::truncate();
        Product::truncate();
        Purchase::truncate();
        PurchaseItem::truncate();
        Sale::truncate();
        SaleItem::truncate();
        Transfer::truncate();
        TransferItem::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Brands
        $brands = [];
        for ($i = 0; $i < 10; $i++) {
            $brands[] = Brand::create([
                'name' => $faker->company,
                'image' => null,
            ]);
        }

        // 2. Warehouses
        $warehouses = [];
        for ($i = 0; $i < 5; $i++) {
            $warehouses[] = WareHouse::create([
                'name' => 'Warehouse ' . $faker->city,
                'city' => $faker->city,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
            ]);
        }

        // 3. Suppliers
        $suppliers = [];
        for ($i = 0; $i < 10; $i++) {
            $suppliers[] = Supplier::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }

        // 4. Customers
        $customers = [];
        for ($i = 0; $i < 20; $i++) {
            $customers[] = Customer::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }

        // 5. Product Categories
        $categories = [];
        for ($i = 0; $i < 8; $i++) {
            $name = $faker->word . ' Category';
            $categories[] = ProductCategory::create([
                'category_name' => $name,
                'category_slug' => \Illuminate\Support\Str::slug($name),
            ]);
        }

        // 6. Products
        $products = [];
        for ($i = 0; $i < 30; $i++) {
            $products[] = Product::create([
                'name' => $faker->word . ' ' . $faker->word,
                'code' => $faker->unique()->ean8,
                'category_id' => $categories[array_rand($categories)]->id,
                'brand_id' => $brands[array_rand($brands)]->id,
                'warehouse_id' => $warehouses[array_rand($warehouses)]->id,
                'supplier_id' => $suppliers[array_rand($suppliers)]->id,
                'price' => $faker->randomFloat(2, 10, 1000),
                'stock_alert' => 10,
                'product_qty' => $faker->numberBetween(50, 200),
                'status' => 'Active',
            ]);
        }

        // 7. Purchases
        for ($i = 0; $i < 15; $i++) {
            $warehouse = $warehouses[array_rand($warehouses)];
            $supplier = $suppliers[array_rand($suppliers)];
            
            $purchase = Purchase::create([
                'date' => $faker->date(),
                'warehouse_id' => $warehouse->id,
                'supplier_id' => $supplier->id,
                'status' => 'Received',
                'grand_total' => 0,
            ]);

            $total = 0;
            for ($j = 0; $j < 3; $j++) {
                $product = $products[array_rand($products)];
                $qty = $faker->numberBetween(5, 20);
                $cost = $product->price * 0.8;
                $subtotal = $qty * $cost;
                $total += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'net_unit_cost' => $cost,
                    'stock' => 100,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }
            $purchase->update(['grand_total' => $total]);
        }

        // 8. Sales
        for ($i = 0; $i < 20; $i++) {
            $warehouse = $warehouses[array_rand($warehouses)];
            $customer = $customers[array_rand($customers)];
            
            $sale = Sale::create([
                'date' => $faker->date(),
                'warehouse_id' => $warehouse->id,
                'customer_id' => $customer->id,
                'status' => 'Sale',
                'grand_total' => 0,
                'paid_amount' => 0,
                'due_amount' => 0,
            ]);

            $total = 0;
            for ($j = 0; $j < 2; $j++) {
                $product = $products[array_rand($products)];
                $qty = $faker->numberBetween(1, 5);
                $price = $product->price;
                $subtotal = $qty * $price;
                $total += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'net_unit_cost' => $price,
                    'stock' => 100,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }
            $sale->update([
                'grand_total' => $total,
                'paid_amount' => $total,
                'due_amount' => 0,
                'full_paid' => 1
            ]);
        }

        // 9. Transfers
        for ($i = 0; $i < 5; $i++) {
            $from = $warehouses[array_rand($warehouses)];
            $to = $warehouses[array_rand($warehouses)];
            while ($from->id === $to->id) {
                $to = $warehouses[array_rand($warehouses)];
            }

            $transfer = Transfer::create([
                'date' => $faker->date(),
                'from_warehouse_id' => $from->id,
                'to_warehouse_id' => $to->id,
                'status' => 'Transfer',
                'grand_total' => 0,
            ]);

            $total = 0;
            for ($j = 0; $j < 3; $j++) {
                $product = $products[array_rand($products)];
                $qty = $faker->numberBetween(5, 15);
                $subtotal = $qty * $product->price;
                $total += $subtotal;

                TransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $product->id,
                    'net_unit_cost' => $product->price,
                    'stock' => 100,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }
            $transfer->update(['grand_total' => $total]);
        }
    }
}
