<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodIssue;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class GoodIssueController extends Controller
{
    public function create()
    {
        try {
            $products = Product::all();
            return view('role-permission.issuer.issue', compact('products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load products: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|max:3', // Max 3 different items per entry
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1', // Valid quantity range for each item
        ]);

        $issuerId = Auth::id();

        try {
            // Calculate the total items being issued in this request
            $newIssueQuantity = array_sum(array_column($request->items, 'quantity'));

            // Calculate the total items issued by this issuer in the current month
            $totalIssuedThisMonth = GoodIssue::where('issuer_id', $issuerId)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('quantity');

            // Check if the new issue would exceed the monthly limit
            if ($totalIssuedThisMonth + $newIssueQuantity > 100) {
                Alert::toast('Monthly issue limit exceeded', 'error');
                return redirect()->back();
            }

            foreach ($request->items as $item) {
                // Check if there's enough stock to issue
                $stock = Inventory::where('product_id', $item['product_id'])->first();
                if ($stock->quantity < $item['quantity']) {
                    $product = Product::find($item['product_id']);
                    Alert::toast('Not enough stock for product: ' . $product->name, 'error');
                    return redirect()->back();
                }

                // Create an issue record
                GoodIssue::create([
                    'issuer_id' => $issuerId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);

                // Update the inventory stock
                $stock->quantity -= $item['quantity'];
                $stock->save();
            }

            Alert::toast('Goods issued successfully', 'success');
            return redirect()->route('issuer.index'); // Redirect to a success page or dashboard
        } catch (\Exception $e) {
            Alert::toast('Failed to issue goods: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}