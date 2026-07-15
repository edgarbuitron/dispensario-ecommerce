<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductService
{
    public function getFilteredProducts($filters = [])
    {
        $query = Product::with(["category", "brand", "images"])->available();

        if (!empty($filters["category"])) {
            $query->whereHas("category", function ($q) use ($filters) {
                $q->where("slug", $filters["category"]);
            });
        }

        if (!empty($filters["brand"])) {
            $query->whereHas("brand", function ($q) use ($filters) {
                $q->where("slug", $filters["brand"]);
            });
        }

        if (!empty($filters["min_price"])) {
            $query->where("price", ">=", $filters["min_price"]);
        }

        if (!empty($filters["max_price"])) {
            $query->where("price", "<=", $filters["max_price"]);
        }

        if (!empty($filters["search"])) {
            $query->where(function ($q) use ($filters) {
                $q->where("name", "like", "%" . $filters["search"] . "%")
                  ->orWhere("description", "like", "%" . $filters["search"] . "%");
            });
        }

        if (!empty($filters["availability"])) {
            $query->where("stock_status", $filters["availability"]);
        }

        if (!empty($filters["on_sale"])) {
            $query->onSale();
        }

        switch ($filters["sort"] ?? "newest") {
            case "oldest":
                $query->orderBy("created_at", "asc");
                break;
            case "price-asc":
                $query->orderBy("price", "asc");
                break;
            case "price-desc":
                $query->orderBy("price", "desc");
                break;
            case "rating":
                $query->orderBy("rating", "desc")->orderBy("reviews_count", "desc");
                break;
            case "name-asc":
                $query->orderBy("name", "asc");
                break;
            case "name-desc":
                $query->orderBy("name", "desc");
                break;
            case "newest":
            default:
                $query->orderBy("created_at", "desc");
                break;
        }

        return $query->paginate(12)->appends($filters);
    }

    public function getFeaturedProducts() { return Product::where("is_featured", true)->limit(8)->get(); }
    public function getNewProducts() { return Product::where("is_new", true)->limit(8)->get(); }
    public function getByCategory($slug) { return Product::whereHas("category", function ($q) use ($slug) { $q->where("slug", $slug); })->paginate(12); }
    public function getRelatedProducts($productId, $limit = 5) { $product = Product::find($productId); if (!$product) return []; return Product::where("category_id", $product->category_id)->where("id", "!=", $productId)->limit($limit)->get(); }
    public function search($query) { return Product::where("name", "like", "%$query%")->orWhere("description", "like", "%$query%")->paginate(12); }
    public function searchProducts($query, $limit = 10) { return Product::with("images")->available()->where(function ($q) use ($query) { $q->where("name", "like", "%$query%")->orWhere("description", "like", "%$query%"); })->limit($limit)->get(); }
    public function getStats() { return ["total" => Product::count(), "featured" => Product::where("is_featured", true)->count(), "new" => Product::where("is_new", true)->count()]; }
    public function getPriceRange() { return ["min" => Product::min("price") ?? 0, "max" => Product::max("price") ?? 1000]; }
}