<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>🌿 ¿Olvidaste algo en tu carrito?</h2>
    <p>Hola {{ $cart->user->name }}, dejaste estos productos esperando por ti:</p>

    <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="text-align: left; padding: 0.5rem;">Producto</th>
                <th style="text-align: center; padding: 0.5rem;">Cant.</th>
                <th style="text-align: right; padding: 0.5rem;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td style="padding: 0.5rem; border-bottom: 1px solid #eee;">{{ $item->product->name ?? 'Producto' }}</td>
                    <td style="text-align: center; padding: 0.5rem; border-bottom: 1px solid #eee;">{{ $item->quantity }}</td>
                    <td style="text-align: right; padding: 0.5rem; border-bottom: 1px solid #eee;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 1.1rem;"><strong>Total: ${{ number_format($cart->total, 2) }}</strong></p>

    <p>
        <a href="{{ route('cart.index') }}" style="display: inline-block; background: #2f5d3a; color: #fff; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 6px;">
            Completar mi compra
        </a>
    </p>
</body>
</html>
