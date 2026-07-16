<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('catalog.index'), 'priority' => '0.9'],
            ['loc' => route('contact'), 'priority' => '0.3'],
            ['loc' => route('faq'), 'priority' => '0.3'],
        ]);

        Category::active()->get()->each(function ($category) use ($urls) {
            $urls->push(['loc' => route('catalog.index', ['category' => $category->slug]), 'priority' => '0.7']);
        });

        Product::available()->get()->each(function ($product) use ($urls) {
            $urls->push([
                'loc' => route('product.show', $product->slug),
                'priority' => '0.8',
                'lastmod' => $product->updated_at->toAtomString(),
            ]);
        });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
