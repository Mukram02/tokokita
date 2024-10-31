<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Logic to display products
        $allProducts = Product::paginate(10);

        return view('products.index', compact('allProducts'));
    }

    public function create()
    {
        // Logic to create a new product
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'deskripsi' => 'nullable|string',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

        // Perbaiki cara upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            // Simpan file ke storage/app/public/products
            $path = $foto->store('products', 'public');
            // path akan berisi 'products/namafile.jpg'
        }

        // Buat produk baru dengan path yang benar
        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'foto' => $path  // Simpan path relatif
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) 
    {
        // Validasi input
       
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string',
        'harga' => 'required|numeric',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

        // Update data produk
        $product->nama = $request->nama;
        $product->harga = $request->harga;
        $product->deskripsi = $request->deskripsi;

        // Perbaiki proses upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }
            
            // Upload foto baru
            $path = $request->file('foto')->store('products', 'public');
            $product->foto = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Update Produk Berhasil');
    }

    public function destroy(Product $product)
    {
        if ($product->foto !== "noimage.png") {
            Storage::disk('local')->delete('public/' . $product->foto);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Delete Product Success');
    }

}
