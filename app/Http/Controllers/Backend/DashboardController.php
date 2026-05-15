<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $availableStock = Product::sum('product_qty');
        $lowStock = Product::where('product_qty', '>', 0)
            ->whereColumn('product_qty', '<=', 'stock_alert')
            ->count();
        $outOfStock = Product::where('product_qty', 0)->count();
        $totalOrders = Sale::count();
        $todaySales = Sale::whereDate('date', today())->sum('grand_total');
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();

        $monthlySalesData = Sale::selectRaw('MONTH(date) as month, SUM(grand_total) as total')
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $salesData = [];
        foreach (range(1, 12) as $m) {
            $salesData[] = (float)($monthlySalesData[$m] ?? 0);
        }

        return view('admin.index', compact(
            'totalProducts', 'availableStock', 'lowStock', 'outOfStock',
            'totalOrders', 'todaySales', 'totalCustomers', 'totalSuppliers',
            'months', 'salesData'
        ));
    }
}
