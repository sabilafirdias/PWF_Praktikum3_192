<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
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
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'qty.required' => 'Jumlah (kuantitas) wajib diisi.',
            'qty.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
            
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            ProductModel::create($validated);

            return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully.');

        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
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
            'qty' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'qty.required' => 'Jumlah (kuantitas) wajib diisi.',
            'qty.integer' => 'Stok harus berupa angka bulat.',
            'qty.min' => 'Stok tidak boleh minus.',
            
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka valid.',
            'price.min' => 'Harga produk tidak boleh minus.',
        ]);

        try {
            $product->update($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error update product ID' . $product->id . ': ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data.');
        }
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
