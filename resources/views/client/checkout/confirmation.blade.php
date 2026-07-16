@extends('layouts.client')

@section('title', 'Confirmación de Orden - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2.5rem auto; max-width: 800px;">

    <!-- Tarjeta de Éxito -->
    <div style="background: var(--color-accent-light); border: 1px solid #cfe3d4; border-radius: var(--radius-lg); padding: 2rem; text-align: center; margin-bottom: 2rem;">
        <p style="font-size: 3rem; margin-bottom: 1rem;">✅</p>
        <h1 style="color: var(--color-accent-dark); font-size: 1.9rem; margin-bottom: 0.5rem;">¡Orden Confirmada!</h1>
        <p style="color: var(--color-accent-dark); font-size: 1.1rem;">Tu pedido ha sido registrado correctamente</p>
    </div>

    <!-- Número de Orden -->
    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.5rem;">Número de Orden</p>
            <h2 style="font-size: 1.9rem; font-family: monospace; letter-spacing: 2px;">{{ $order->order_number }}</h2>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 2rem 0; border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
            <div>
                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.5rem;">Fecha</p>
                <p style="font-weight: 600;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.5rem;">Estado</p>
                <span class="badge-pill badge-warning">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Detalles de la Orden -->
    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Detalles de la Orden</h2>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--color-border);">
                        <th style="text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Producto</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Cantidad</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Precio</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600; font-size: 0.9rem;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid var(--color-border);">
                            <td style="padding: 1rem;">{{ $item->product->name }}</td>
                            <td style="text-align: center; padding: 1rem;">{{ $item->quantity }}</td>
                            <td style="text-align: right; padding: 1rem;">${{ number_format($item->unit_price, 2) }}</td>
                            <td style="text-align: right; padding: 1rem; font-weight: 600;">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen Financiero -->
    <div style="background: var(--color-surface-alt); border-radius: var(--radius-lg); padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <span>Subtotal:</span>
            <strong>${{ number_format($order->subtotal, 2) }}</strong>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <span>Envío:</span>
            <strong>${{ number_format($order->shipping, 2) }}</strong>
        </div>

        @if($order->discount)
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border); color: var(--color-accent);">
                <span>Descuento:</span>
                <strong>-${{ number_format($order->discount, 2) }}</strong>
            </div>
        @endif

        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 700;">
            <span>Total:</span>
            <strong>${{ number_format($order->total, 2) }}</strong>
        </div>
    </div>

    <!-- Dirección de Envío -->
    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">📍 Dirección de Envío</h2>

        <p style="margin-bottom: 0.5rem; font-weight: 600;">{{ $order->address->label }}</p>
        <p class="text-muted" style="margin-bottom: 0.5rem;">{{ $order->address->getFullAddress() }}</p>
        <p class="text-muted">📞 {{ $order->address->phone }}</p>
    </div>

    <!-- Información de Pago -->
    <div style="background: var(--color-accent-light); border-left: 4px solid var(--color-accent); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: var(--color-accent-dark); font-size: 1.1rem; margin-bottom: 1rem;">💳 Información de Pago</h3>

        <p style="color: var(--color-accent-dark); margin-bottom: 1rem;">
            Tu orden está en estado <strong>Pendiente de Pago</strong>. Por favor, realiza una transferencia bancaria con los siguientes datos:
        </p>

        @if($bankAccounts && $bankAccounts->first())
            @foreach($bankAccounts as $account)
                <div style="background: #fff; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1rem;">
                    <p style="font-weight: 600; margin-bottom: 0.5rem;">{{ $account->bank_name }}</p>
                    <p class="text-muted" style="font-size: 0.9rem;">Titular: {{ $account->account_holder }}</p>
                    <p class="text-muted" style="font-size: 0.9rem;">CLABE: <strong style="color: var(--color-text);">{{ $account->clabe }}</strong></p>
                    @if($account->account_number)
                        <p class="text-muted" style="font-size: 0.9rem;">Cuenta: <strong style="color: var(--color-text);">{{ $account->account_number }}</strong></p>
                    @endif
                </div>
            @endforeach

            <div style="background: #fff; padding: 1rem; border-radius: var(--radius-sm);">
                <p style="color: var(--color-accent-dark); font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Concepto de pago:</p>
                <p style="font-family: monospace; background: var(--color-surface-alt); padding: 0.5rem; border-radius: var(--radius-sm);">
                    Pago pedido {{ $order->order_number }}
                </p>
            </div>
        @endif

        <p style="color: var(--color-accent-dark); font-size: 0.9rem; margin-top: 1rem;">
            Una vez recibido tu pago, te enviaremos un email de confirmación.
        </p>
    </div>

    <!-- Próximos Pasos -->
    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">📋 Próximos Pasos</h2>

        <ol class="text-muted" style="line-height: 1.8; margin-left: 1.5rem;">
            <li style="margin-bottom: 1rem;">
                <strong style="color: var(--color-text);">Realiza la transferencia bancaria</strong> con el monto exacto y el concepto indicado arriba
            </li>
            <li style="margin-bottom: 1rem;">
                <strong style="color: var(--color-text);">Carga el comprobante</strong> en tu cuenta para acelerar la confirmación
            </li>
            <li style="margin-bottom: 1rem;">
                <strong style="color: var(--color-text);">Espera confirmación</strong> de nuestro equipo (máximo 24 horas hábiles)
            </li>
            <li>
                <strong style="color: var(--color-text);">Recibe tu pedido</strong> en la dirección indicada dentro de los plazos establecidos
            </li>
        </ol>
    </div>

    <!-- Botones de Acción -->
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary" style="padding: 0.9rem 2rem;">
            Ver Orden Completa
        </a>
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="padding: 0.9rem 2rem;">
            Continuar Comprando
        </a>
    </div>

    <!-- Contacto -->
    <div style="background: var(--color-surface-alt); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; margin-top: 2rem;">
        <p class="text-muted" style="margin-bottom: 0.5rem;">¿Tienes preguntas?</p>
        <p style="margin-bottom: 1rem;">
            <a href="https://wa.me/5215512345678" target="_blank" style="color: #25d366; font-weight: 600; text-decoration: none;">
                💬 Contáctanos por WhatsApp
            </a>
        </p>
        <p class="text-muted" style="font-size: 0.9rem;">
            Te enviaremos un email de confirmación con todos los detalles de tu orden.
        </p>
    </div>
</div>

@endsection
