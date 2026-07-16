@extends('layouts.client')

@section('title', 'Carrito - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2.5rem auto;">
    <h1 style="font-size: 1.9rem; margin-bottom: 2rem;">🛒 Tu Carrito</h1>

    @if($cart && $cart->items()->count() > 0)
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">

            <!-- Lista de Productos -->
            <div class="card" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--color-border);">
                                <th style="text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Producto</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Precio</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Cantidad</th>
                                <th style="text-align: right; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Subtotal</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr style="border-bottom: 1px solid var(--color-border);">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 1rem; align-items: center;">
                                            @if($item->product->getPrimaryImage())
                                                <img src="{{ asset('storage/products/' . $item->product->getPrimaryImage()->image_path) }}"
                                                     style="width: 76px; height: 76px; object-fit: cover; border-radius: var(--radius-sm);" alt="">
                                            @else
                                                <div style="width: 76px; height: 76px; background: var(--color-surface-alt); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">📦</div>
                                            @endif
                                            <div>
                                                <p style="font-weight: 600; margin-bottom: 0.25rem;">
                                                    <a href="{{ route('product.show', $item->product->slug) }}" style="color: inherit; text-decoration: none;">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </p>
                                                <p class="text-muted" style="font-size: 0.85rem;">SKU: {{ $item->product->sku }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        ${{ number_format($item->price, 2) }}
                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="10"
                                                   style="width: 60px; padding: 0.5rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.85rem;">✓</button>
                                        </form>
                                    </td>
                                    <td style="text-align: right; padding: 1rem; font-weight: 600;">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('¿Eliminar del carrito?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" style="padding: 0.5rem 0.85rem;">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Botones de Acción -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-border);">
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary">← Continuar Comprando</a>
                    <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('¿Vaciar carrito?');" style="margin-left: auto;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">🗑️ Vaciar Carrito</button>
                    </form>
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <aside>
                <div class="card" style="padding: 1.75rem; position: sticky; top: 90px;">
                    <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Resumen</h2>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
                        <span>Subtotal:</span>
                        <strong>${{ number_format($cart->subtotal, 2) }}</strong>
                    </div>

                    @if($cart->tax)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
                            <span>Impuestos:</span>
                            <strong>${{ number_format($cart->tax, 2) }}</strong>
                        </div>
                    @endif

                    @if($cart->discount)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border); color: var(--color-accent);">
                            <span>Descuento:</span>
                            <strong>-${{ number_format($cart->discount, 2) }}</strong>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1.2rem; font-weight: 700;">
                        <span>Total:</span>
                        <strong>${{ number_format($cart->total, 2) }}</strong>
                    </div>

                    <!-- Cupón -->
                    <form method="POST" action="{{ route('cart.coupon') }}" style="margin-bottom: 1.5rem;">
                        @csrf
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" name="coupon_code" placeholder="Código de cupón"
                                   style="flex: 1; padding: 0.7rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                            <button type="submit" class="btn btn-secondary">Aplicar</button>
                        </div>
                        @if($errors->has('coupon_code'))
                            <p style="color: var(--color-danger); font-size: 0.9rem; margin-top: 0.5rem;">{{ $errors->first('coupon_code') }}</p>
                        @endif
                    </form>

                    @auth
                        <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%; text-align: center; padding: 0.9rem; display: block;">
                            Proceder al Pago
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; text-align: center; padding: 0.9rem; display: block;">
                            Iniciar Sesión para Comprar
                        </a>
                    @endauth

                    <p class="text-muted" style="font-size: 0.85rem; text-align: center; margin-top: 1rem;">
                        Envío gratis en compras mayores a $500
                    </p>
                </div>
            </aside>
        </div>
    @else
        <div class="card" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 1.4rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">🛒 Tu carrito está vacío</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 0.9rem 2rem; font-size: 1rem;">
                Explorar Productos
            </a>
        </div>
    @endif
</div>

@endsection
