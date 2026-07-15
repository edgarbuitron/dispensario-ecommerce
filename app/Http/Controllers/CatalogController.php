<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Wishlist;
use App\Services\ProductService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): View
    {
        $filters = [
            'category' => $request->get('category'),
            'brand' => $request->get('brand'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'availability' => $request->get('availability'),
            'on_sale' => $request->get('on_sale'),
            'search' => $request->get('search'),
            'sort' => $request->get('sort', 'newest'),
        ];

        $products = $this->productService->getFilteredProducts($filters);
        $categories = Category::active()->orderBy('sort_order')->get();
        $brands = Brand::active()->orderBy('sort_order')->get();
        $priceRange = $this->productService->getPriceRange();
        $wishlistedIds = $this->wishlistedIds();

        return view('client.catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'priceRange' => $priceRange,
            'filters' => $filters,
            'wishlistedIds' => $wishlistedIds,
        ]);
    }

    public function show(Request $request, $slug): View
    {
        $product = Product::with(['category', 'brand', 'images', 'attributes', 'reviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        if (!$product->isAvailable()) {
            abort(404);
        }

        $relatedProducts = $this->productService->getRelatedProducts($product->id, 4);

        $userReview = auth()->check()
            ? $product->reviews()->where('user_id', auth()->id())->first()
            : null;

        return view('client.catalog.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'wishlistedIds' => $this->wishlistedIds(),
            'userReview' => $userReview,
        ]);
    }

    protected function wishlistedIds(): array
    {
        if (!auth()->check()) {
            return [];
        }

        return Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
    }

    public function quickSearch(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $products = $this->productService->searchProducts($query, 10);

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->getFormattedPrice(),
                'image' => $product->getPrimaryImage()?->getImageUrl(),
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function byCategory(Request $request, $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $filters = [
            'category' => $slug,
            'sort' => $request->get('sort', 'newest'),
        ];

        $products = $this->productService->getFilteredProducts($filters);
        $brands = Brand::active()->orderBy('sort_order')->get();

        return view('client.catalog.category', [
            'category' => $category,
            'products' => $products,
            'brands' => $brands,
            'filters' => $filters,
        ]);
    }

    public function byBrand(Request $request, $slug): View
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();

        $filters = [
            'brand' => $slug,
            'sort' => $request->get('sort', 'newest'),
        ];

        $products = $this->productService->getFilteredProducts($filters);
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('client.catalog.brand', [
            'brand' => $brand,
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }
}
