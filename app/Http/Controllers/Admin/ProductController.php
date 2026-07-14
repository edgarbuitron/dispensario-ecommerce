<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController
{
    public function index()
    {
        $products = Product::with(["category", "brand"])->paginate(15);
        return view("admin.products.index", compact("products"));
    }

    public function create()
    {
        return redirect("/admin/products")->with("info", "Usa editar para modificar productos existentes");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view("admin.products.edit", compact("product", "categories", "brands"));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "stock_quantity" => "required|integer",
            "is_active" => "boolean",
        ]);

        $product->update($validated);
        cache()->forget("products_" . $product->id);
        return redirect("/admin/products")->with("success", "✅ Producto actualizado!");
    }
}
