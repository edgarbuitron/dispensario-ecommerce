<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        
        return view('client.cart.index', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->get('product_id'));
        $quantity = $request->get('quantity', 1);

        if ($product->isOutOfStock()) {
            return response()->json(['success' => false, 'message' => 'Producto agotado'], 400);
        }

        $this->cartService->addProduct($product, $quantity);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'cartCount' => $this->cartService->getCartCount(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, $cartItemId)
    {
        $quantity = $request->get('quantity', 1);
        $this->cartService->updateQuantity($cartItemId, $quantity);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
    }

    public function remove($cartItemId)
    {
        $this->cartService->removeItem($cartItemId);

        return redirect()->route('cart.index')->with('success', 'Producto removido del carrito');
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Carrito vaciado');
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->get('coupon_code');
        $result = $this->cartService->applyCoupon($code);

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('cart.index')->with('success', $result['message']);
        }

        return redirect()->route('cart.index')->with('error', $result['message']);
    }

    public function getCartMini()
    {
        $cart = $this->cartService->getCart();

        return response()->json([
            'count' => $this->cartService->getCartCount(),
            'total' => $this->cartService->getCartTotal(),
            'items' => $cart->items()->with('product')->get(),
        ]);
    }
}
