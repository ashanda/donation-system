<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return view('role-permission.products.index', compact('products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load products: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return view('role-permission.products.create');
        } catch (\Exception $e) {
            Alert::toast('Failed to load create form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            Product::create($request->all());
            Alert::toast('Product created successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to create product: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('products.index');
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('role-permission.products.show', compact('product'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load product: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('role-permission.products.edit', compact('product'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load edit form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            Alert::toast('Product updated successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to update product: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        
        try {
            $product = Product::findOrFail($id);
            $product->delete(); // Soft delete
            Alert::toast('Product deleted successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete product: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('products.index');
    }

    public function restoreItems()
    {
        try {
            $products = Product::onlyTrashed()->get();
            return view('role-permission.products.restore', compact('products'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load restore page: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function forceDelete($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->forceDelete();
            Alert::toast('Product permanently deleted', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to permanently delete product: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('products.index');
    }

    public function restore($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();
            Alert::toast('Product restored successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to restore product: ' . $e->getMessage(), 'error');
        }
        return redirect()->route('products.index');
    }
}
