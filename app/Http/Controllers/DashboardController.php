<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Top Products Donated
            $topProducts = DB::table('donations')
                ->join('products', 'donations.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(donations.quantity) as total'))
                ->groupBy('products.name')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

            // Top 5 Donators
            $topDonators = User::select('users.name', DB::raw('SUM(donations.quantity) as total'))
                ->join('donations', 'users.id', '=', 'donations.donator_id')
                ->groupBy('users.name')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

            // Low Stock Products
            $lowStockProducts = Product::whereHas('inventory', function ($query) {
                $query->where('quantity', '<', 5);
            })->with('inventory')->get();

            return view('dashboard', compact('topProducts', 'topDonators', 'lowStockProducts'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load dashboard data: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}


