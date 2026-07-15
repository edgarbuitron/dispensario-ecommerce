<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>¡Gracias por tu compra, {{ $order->user->name }}!</h2>
    <p>Recibimos tu orden <strong>{{ $order->order_number }}</strong> y está pendiente de pago.</p>

    <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="text-align: left; padding: 0.5rem;">Producto</th>
                <th style="text-align: center; padding: 0.5rem;">Cant.</th>
                <th style="text-align: right; padding: 0.5rem;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 0.5rem; border-bottom: 1px solid #eee;">{{ $item->product_name }}</td>
                    <td style="text-align: center; padding: 0.5rem; border-bottom: 1px solid #eee;">{{ $item->quantity }}</td>
                    <td style="text-align: right; padding: 0.5rem; border-bottom: 1px solid #eee;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 1.2rem;"><strong>Total: ${{ number_format($order->total, 2) }}</strong></p>

    <p>Sube tu comprobante de pago desde tu cuenta para que podamos procesar tu orden.</p>
</body>
</html>
