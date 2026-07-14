<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Auth;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }
        
        return $cart;
    }

    public function addProduct(Product $product, int $quantity = 1)
    {
        $cart = $this->getCart();
        
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->updateQuantity($cartItem->quantity + $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $quantity * $product->price,
            ]);
        }

        $cart->recalculate();
        return $cart;
    }

    public function updateQuantity($cartItemId, int $quantity)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        
        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->updateQuantity($quantity);
        }

        $cartItem->cart->recalculate();
        return $cartItem->cart;
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->recalculate();
        return $cart;
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->clear();
        return $cart;
    }

    public function applyCoupon($code)
    {
        $cart = $this->getCart();
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return ['success' => false, 'message' => 'Cupón inválido o expirado'];
        }

        if (!$coupon->canBeUsed($cart->subtotal)) {
            return ['success' => false, 'message' => 'No cumples los requisitos para este cupón'];
        }

        $discount = $coupon->getDiscountAmount($cart->subtotal);
        
        $cart->update([
            'coupon_code' => $code,
            'discount' => $discount,
            'total' => $cart->subtotal - $discount,
        ]);

        return ['success' => true, 'message' => 'Cupón aplicado correctamente', 'discount' => $discount];
    }

    public function getCartCount()
    {
        return $this->getCart()->items()->sum('quantity');
    }

    public function getCartTotal()
    {
        return $this->getCart()->total ?? 0;
    }
}
