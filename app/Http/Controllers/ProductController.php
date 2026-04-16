<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = ProductModel::all();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $validated['user_id'] = auth()->id();

        ProductModel::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }


    public function show(ProductModel $product)
    {
        return view('product.view', compact('product'));
    }

    public function edit(ProductModel $product)
    {
        $this->authorize('update', $product);
        $users = User::orderBy('name')->get();

        return view('product.edit', compact('product', 'users'));
    }

    public function update(Request $request, ProductModel $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'qty' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete(ProductModel $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }

    public function export()
    {
        if (Gate::denies('manage-product')) {
            abort(403, 'Unauthorized action.');
        }

        $products = ProductModel::all();
        return view('product.export', compact('products'));
    }
}
