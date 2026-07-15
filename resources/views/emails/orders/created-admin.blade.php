<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Nueva orden recibida</h2>
    <p><strong>Orden:</strong> {{ $order->order_number }}</p>
    <p><strong>Cliente:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
    <p><strong>Método de pago:</strong> {{ $order->payment_method }}</p>

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

    <p>Revísala en el panel de administración.</p>
</body>
</html>
