<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        ProductReview::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            [
                'customer_name' => auth()->user()->name,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        $reviews = $product->reviews()->get();
        $product->update([
            'rating' => round($reviews->avg('rating'), 2),
            'reviews_count' => $reviews->count(),
        ]);

        return back()->with('success', '✅ ¡Gracias por tu reseña!');
    }
}
