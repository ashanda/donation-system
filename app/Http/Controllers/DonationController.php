<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DonationController extends Controller
{
    public function create()
    {
        try {
            $products = Product::all();
            return view('role-permission.donator.donate', compact('products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load products: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $donatorId = Auth::id();

        try {
            // Calculate the total items being donated in this request
            $newDonationQuantity = array_sum(array_column($request->items, 'quantity'));

            // Calculate the total items donated by this donator in the current month
            $totalDonatedThisMonth = Donation::where('donator_id', $donatorId)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('quantity');

            // Check if the new donation would exceed the monthly limit
            if ($totalDonatedThisMonth + $newDonationQuantity > 300) {
                Alert::toast('Monthly donation limit exceeded', 'error');
                return redirect()->back();
            }

            foreach ($request->items as $item) {
                // Check if the product already exists
                $product = Product::where('name', $item['product_name'])->first();

                if (!$product) {
                    // Create a new product if it doesn't exist
                    $product = Product::create([
                        'name' => $item['product_name'],
                        'product_code' => 'PROD-' . strtoupper(uniqid()),
                        'price' => $item['price'],
                    ]);

                    // Create a new inventory record for the new product
                    $inventory = Inventory::create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                    ]);
                } else {
                    // Update the inventory record for the existing product
                    $inventory = Inventory::where('product_id', $product->id)->first();
                    $inventory->quantity += $item['quantity'];
                    $inventory->save();
                }

                // Create a donation record
                Donation::create([
                    'donator_id' => $donatorId,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                ]);
            }

            Alert::toast('Donation recorded successfully', 'success');
            return redirect()->route('donator.index'); 
        } catch (\Exception $e) {
            Alert::toast('Failed to record donation: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
