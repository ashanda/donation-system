<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    public function index()
    {
        try {
            $inventories = Inventory::all();
            return view('role-permission.inventory.index', compact('inventories'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load inventories: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $products = Product::all(); // Fetch all products to populate the dropdown
            return view('role-permission.inventory.create', compact('products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load create form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            Inventory::create($request->all()); // Create inventory instead of product
            Alert::toast('Inventory created successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to create inventory: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('inventories.index');
    }

    public function show($id)
    {
       
        try {
            $inventory = Inventory::findOrFail($id); // Find inventory instead of product
            return view('role-permission.inventory.show', compact('inventory'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load inventory: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $inventory = Inventory::findOrFail($id); // Find inventory instead of product
            $products = Product::all(); // Fetch all products to populate the dropdown
            return view('role-permission.inventory.edit', compact('inventory', 'products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load edit form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $inventory = Inventory::findOrFail($id); // Find inventory instead of product
            $inventory->update($request->all());
            Alert::toast('Inventory updated successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to update inventory: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('inventories.index');
    }

    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id); // Find inventory instead of product
            $inventory->delete(); // Soft delete
            Alert::toast('Inventory deleted successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete inventory: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('inventories.index');
    }

    public function forceDelete($id)
        {
            
            try {
                $inventory = Inventory::withTrashed()->findOrFail($id); // Find inventory instead of product
                $inventory->forceDelete();
                Alert::toast('Inventory permanently deleted', 'success');
            } catch (ModelNotFoundException $e) {
                Alert::toast('Inventory not found', 'error');
            } catch (\Exception $e) {
                Alert::toast('Failed to permanently delete inventory: ' . $e->getMessage(), 'error');
            }
            return redirect()->route('inventories.index');
        }

    public function restore($id)
    {
        try {
            $inventory = Inventory::withTrashed()->findOrFail($id); // Find inventory instead of product
            $inventory->restore();
            Alert::toast('Inventory restored successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to restore inventory: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('inventories.index');
    }

    public function restoreItems()
    {
        try {
            $inventories = Inventory::onlyTrashed()->get();
            return view('role-permission.inventory.restore', compact('inventories'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load restore page: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
