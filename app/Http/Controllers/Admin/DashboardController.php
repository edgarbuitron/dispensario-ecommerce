<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $today = Carbon::now()->startOfDay();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // Estadísticas de órdenes
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending_payment')->count(),
            'confirmed_orders' => Order::where('status', 'payment_confirmed')->count(),
            'today_orders' => Order::where('created_at', '>=', $today)->count(),
            'month_orders' => Order::where('created_at', '>=', $thisMonth)->count(),
        ];

        // Estadísticas de clientes
        $stats['total_customers'] = User::count();
        $stats['new_customers'] = User::where('created_at', '>=', $thisMonth)->count();
        $stats['active_customers'] = User::where('is_active', true)->count();

        // Estadísticas de productos
        $stats['total_products'] = Product::count();
        $stats['active_products'] = Product::active()->count();
        $stats['out_of_stock'] = Product::where('stock_status', 'out_of_stock')->count();
        $stats['featured_products'] = Product::featured()->count();

        // Ingresos
        $stats['today_revenue'] = Order::where('created_at', '>=', $today)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        $stats['month_revenue'] = Order::where('created_at', '>=', $thisMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        $stats['year_revenue'] = Order::where('created_at', '>=', $thisYear)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        // Órdenes recientes
        $recentOrders = Order::with('user', 'address')
            ->latest()
            ->limit(10)
            ->get();

        // Órdenes pendientes de aprobación
        $pendingApprovals = Order::where('status', 'proof_received')
            ->with('user', 'proofs')
            ->latest()
            ->limit(5)
            ->get();

        // Gráfica de ventas últimos 7 días
        $salesChart = $this->getSalesChart();

        // Categorías más vendidas
        $topCategories = Category::withCount('products')->orderBy('products_count', 'desc')->limit(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'pendingApprovals' => $pendingApprovals,
            'salesChart' => $salesChart,
            'topCategories' => $topCategories,
        ]);
    }

    private function getSalesChart()
    {
        $days = [];
        $sales = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');
            
            $amount = Order::where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', $date->endOfDay())
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            
            $sales[] = $amount;
        }

        return [
            'labels' => $days,
            'data' => $sales,
        ];
    }
}
