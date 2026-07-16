@extends('layouts.client')

@section('title', 'Pagar Orden ' . $order->order_number . ' - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2.5rem auto; max-width: 800px;">

    <div style="background: #fdf1d9; border: 1px solid #f2dfae; border-radius: var(--radius-lg); padding: 2rem; text-align: center; margin-bottom: 2rem;">
        <p style="font-size: 3rem; margin-bottom: 1rem;">⏳</p>
        <h1 style="color: #8a6116; font-size: 1.7rem; margin-bottom: 0.5rem;">Tu orden está pendiente de pago</h1>
        <p style="color: #8a6116;">Orden <strong>{{ $order->order_number }}</strong> — Total: <strong>${{ number_format($order->total, 2) }}</strong></p>
    </div>

    <!-- Datos Bancarios -->
    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">💳 Datos para tu transferencia</h2>

        @if($bankAccounts && $bankAccounts->count() > 0)
            @foreach($bankAccounts as $account)
                <div style="background: var(--color-surface-alt); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 1rem;">
                    <p style="font-weight: 700; margin-bottom: 0.5rem;">{{ $account->bank_name }}</p>
                    <p class="text-muted" style="font-size: 0.95rem;">Titular: <strong style="color: var(--color-text);">{{ $account->account_holder }}</strong></p>
                    @if($account->account_number)
                        <p class="text-muted" style="font-size: 0.95rem;">Cuenta: <strong style="color: var(--color-text);">{{ $account->account_number }}</strong></p>
                    @endif
                    <p class="text-muted" style="font-size: 0.95rem;">CLABE: <strong style="color: var(--color-text);">{{ $account->clabe }}</strong></p>
                    @if($account->swift_code)
                        <p class="text-muted" style="font-size: 0.95rem;">SWIFT: <strong style="color: var(--color-text);">{{ $account->swift_code }}</strong></p>
                    @endif
                    @if($account->instructions)
                        <p class="text-muted" style="font-size: 0.85rem; margin-top: 0.5rem;">{{ $account->instructions }}</p>
                    @endif
                </div>
            @endforeach

            <div style="background: var(--color-surface-alt); padding: 1rem; border-radius: var(--radius-md);">
                <p style="font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Concepto de pago:</p>
                <p style="font-family: monospace; background: #fff; padding: 0.5rem; border-radius: var(--radius-sm); border: 1px solid var(--color-border);">
                    Pago pedido {{ $order->order_number }}
                </p>
            </div>
        @else
            <p class="text-muted">Aún no hay cuentas bancarias configuradas. Contáctanos para coordinar el pago.</p>
        @endif
    </div>

    <!-- Siguiente Paso -->
    <div style="background: var(--color-accent-light); border-left: 4px solid var(--color-accent); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
        <h3 style="color: var(--color-accent-dark); font-size: 1.1rem; margin-bottom: 1rem;">📤 Ya hiciste la transferencia?</h3>
        <p style="color: var(--color-accent-dark); margin-bottom: 1.5rem;">Sube tu comprobante para que podamos confirmar tu pago lo antes posible.</p>
        <a href="{{ route('order.upload-proof.form', $order) }}" class="btn btn-primary" style="padding: 0.9rem 2rem;">
            Subir Comprobante de Pago
        </a>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Orden Completa</a>
        <a href="{{ route('order.tracking', $order) }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Seguimiento</a>
    </div>
</div>

@endsection
