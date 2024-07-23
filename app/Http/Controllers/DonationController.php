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
    public function index()
    {
        try {
            $user = Auth::user();
            $roles = $user->getRoleNames();

            if ($roles->contains('super-admin') || $roles->contains('admin')) {
                $donations = Donation::with('product')->get();
            } elseif ($roles->contains('donator')) {
                $donations = Donation::with('product')->where('donator_id', $user->id)->get();
            } else {
                $donations = collect();
            }

            return view('role-permission.donator.index', compact('donations'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load donations: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

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
            $newDonationQuantity = array_sum(array_column($request->items, 'quantity'));
            $totalDonatedThisMonth = Donation::where('donator_id', $donatorId)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('quantity');

            if ($totalDonatedThisMonth + $newDonationQuantity > 300) {
                Alert::toast('Monthly donation limit exceeded', 'error');
                return redirect()->back();
            }

            foreach ($request->items as $item) {
                $product = Product::where('name', $item['product_name'])->first();

                if (!$product) {
                    $product = Product::create([
                        'name' => $item['product_name'],
                        'product_code' => 'PROD-' . strtoupper(uniqid()),
                        'price' => $item['price'],
                    ]);

                    Inventory::create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                    ]);
                } else {
                    $inventory = Inventory::where('product_id', $product->id)->first();
                    $inventory->quantity += $item['quantity'];
                    $inventory->save();
                }

                Donation::create([
                    'donator_id' => $donatorId,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                ]);
            }

            Alert::toast('Donation recorded successfully', 'success');
            return redirect()->route('donations.index'); 
        } catch (\Exception $e) {
            Alert::toast('Failed to record donation: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function edit(Donation $donation)
    {
        try {
            $products = Product::all();
            return view('role-permission.donator.edit', compact('donation', 'products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load donation: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $inventory = Inventory::where('product_id', $donation->product_id)->first();
            $newStockQuantity = $inventory->quantity - $donation->quantity + $request->quantity;

            if ($newStockQuantity < 0) {
                Alert::toast('Not enough stock for the update', 'error');
                return redirect()->back();
            }

            $inventory->quantity = $newStockQuantity;
            $inventory->save();

            $donation->update($request->all());

            Alert::toast('Donation updated successfully', 'success');
            return redirect()->route('donations.index');
        } catch (\Exception $e) {
            Alert::toast('Failed to update donation: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function destroy(Donation $donation)
    {
        try {
            $inventory = Inventory::where('product_id', $donation->product_id)->first();
            $inventory->quantity -= $donation->quantity;
            $inventory->save();

            $donation->delete();

            Alert::toast('Donation deleted successfully', 'success');
            return redirect()->route('donations.index');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete donation: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
