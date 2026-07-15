<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $products = Product::whereHas('wishlistedBy', function ($q) {
            $q->where('user_id', auth()->id());
        })->with(['category', 'brand', 'images'])->get();

        return view('client.wishlist.index', ['products' => $products]);
    }

    public function toggle(Request $request, Product $product)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $inWishlist = false;
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
            $inWishlist = true;
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'in_wishlist' => $inWishlist]);
        }

        return back()->with('success', $inWishlist ? '❤️ Agregado a favoritos' : 'Eliminado de favoritos');
    }
}
