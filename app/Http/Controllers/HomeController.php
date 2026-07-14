<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): View
    {
        $banners = Banner::byPosition('hero')->get();
        $featuredProducts = $this->productService->getFeaturedProducts(8);
        $newProducts = $this->productService->getNewProducts(8);
        $categories = Category::active()->orderBy('sort_order')->get();
        $promotions = \App\Models\Promotion::active()->limit(3)->get();

        return view('client.index', [
            'banners' => $banners,
            'featuredProducts' => $featuredProducts,
            'newProducts' => $newProducts,
            'categories' => $categories,
            'promotions' => $promotions,
        ]);
    }

    public function about(): View
    {
        return view('client.about');
    }

    public function contact(): View
    {
        return view('client.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Enviar email
        \Mail::to(config('app.support_email'))
            ->send(new \App\Mail\ContactForm($validated));

        return redirect()->back()->with('success', 'Mensaje enviado correctamente');
    }

    public function faq(): View
    {
        $faqs = [
            [
                'question' => '¿Cuál es el plazo de entrega?',
                'answer' => 'Los pedidos se entregan en 3-5 días hábiles en CDMX. Otros estados pueden tardar más.',
            ],
            [
                'question' => '¿Puedo devolver un producto?',
                'answer' => 'Consulta nuestra política de devoluciones para más información.',
            ],
            [
                'question' => '¿Qué métodos de pago aceptan?',
                'answer' => 'Aceptamos transferencia bancaria. En el futuro habilitaremos más opciones.',
            ],
        ];

        return view('client.faq', ['faqs' => $faqs]);
    }

    public function terms(): View
    {
        return view('client.legal.terms');
    }

    public function privacy(): View
    {
        return view('client.legal.privacy');
    }

    public function shipping(): View
    {
        return view('client.legal.shipping');
    }

    public function returns(): View
    {
        return view('client.legal.returns');
    }
}
