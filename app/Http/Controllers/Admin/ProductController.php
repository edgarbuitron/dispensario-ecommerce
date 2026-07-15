<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(["category", "brand"])->latest()->paginate(15);
        return view("admin.products.index", compact("products"));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $brands = Brand::orderBy('sort_order')->get();
        return view("admin.products.create", compact("categories", "brands"));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['sku'] = 'SKU-' . strtoupper(Str::random(8));
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_active'] = $request->has('is_active');
        $validated['cost_price'] = $validated['cost_price'] ?? round($validated['price'] * 0.4, 2);

        $product = Product::create($validated);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', '✅ Producto creado correctamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('sort_order')->get();
        $brands = Brand::orderBy('sort_order')->get();
        $product->load('images');
        return view("admin.products.edit", compact("product", "categories", "brands"));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', '✅ Producto actualizado!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', '🗑️ Producto eliminado correctamente');
    }

    public function deleteImage(ProductImage $productImage)
    {
        $path = storage_path('app/public/products/' . $productImage->image_path);

        if (file_exists($path)) {
            unlink($path);
        }

        $wasPrimary = $productImage->is_primary;
        $productId = $productImage->product_id;
        $productImage->delete();

        if ($wasPrimary) {
            ProductImage::where('product_id', $productId)->oldest('sort_order')->first()?->update(['is_primary' => true]);
        }

        return back()->with('success', '🗑️ Imagen eliminada correctamente');
    }

    protected function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:90',
            'cost_price' => 'nullable|numeric|min:0',
            'type' => 'nullable|string|max:255',
            'flavor' => 'nullable|string|max:255',
            'presentation' => 'nullable|string|max:255',
            'stock_status' => 'required|in:available,low,out_of_stock,hidden',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    }

    protected function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    protected function storeImages(Request $request, Product $product): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $hasPrimary = $product->images()->where('is_primary', true)->exists();
        $nextSort = (int) $product->images()->max('sort_order');

        foreach ($request->file('images') as $file) {
            $filename = $product->slug . '-' . uniqid() . '.' . $file->extension();
            $file->storeAs('products', $filename, 'public');

            $product->images()->create([
                'image_path' => $filename,
                'alt_text' => $product->name,
                'is_primary' => !$hasPrimary,
                'sort_order' => ++$nextSort,
            ]);

            $hasPrimary = true;
        }
    }
}
