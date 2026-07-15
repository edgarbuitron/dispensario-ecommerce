@extends('layouts.client')

@section('title', 'Confirmación de Orden - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; max-width: 800px;">
    
    <!-- Tarjeta de Éxito -->
    <div style="background: #d4edda; border: 2px solid #28a745; border-radius: 8px; padding: 2rem; text-align: center; margin-bottom: 2rem;">
        <p style="font-size: 3rem; margin-bottom: 1rem;">✅</p>
        <h1 style="color: #155724; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">¡Orden Confirmada!</h1>
        <p style="color: #155724; font-size: 1.1rem;">Tu pedido ha sido registrado correctamente</p>
    </div>
    
    <!-- Número de Orden -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Número de Orden</p>
            <h2 style="font-size: 2rem; font-weight: 700; font-family: monospace; letter-spacing: 2px;">{{ $order->order_number }}</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 2rem 0; border-top: 1px solid #e9ecef; border-bottom: 1px solid #e9ecef;">
            <div>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Fecha</p>
                <p style="font-weight: 600;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Estado</p>
                <p style="display: inline-block; background: #ffc107; color: #000; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Detalles de la Orden -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Detalles de la Orden</h2>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Producto</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Cantidad</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600;">Precio</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #e9ecef;">
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
    <div style="background: #f8f9fa; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
            <span>Subtotal:</span>
            <strong>${{ number_format($order->subtotal, 2) }}</strong>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
            <span>Envío:</span>
            <strong>${{ number_format($order->shipping, 2) }}</strong>
        </div>
        
        @if($order->discount)
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; color: #28a745;">
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
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">📍 Dirección de Envío</h2>
        
        <p style="margin-bottom: 0.5rem; font-weight: 600;">{{ $order->address->label }}</p>
        <p style="color: #666; margin-bottom: 0.5rem;">{{ $order->address->getFullAddress() }}</p>
        <p style="color: #666;">📞 {{ $order->address->phone }}</p>
    </div>
    
    <!-- Información de Pago -->
    <div style="background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: #1565c0; font-weight: 700; margin-bottom: 1rem;">💳 Información de Pago</h3>
        
        <p style="color: #1565c0; margin-bottom: 1rem;">
            Tu orden está en estado <strong>Pendiente de Pago</strong>. Por favor, realiza una transferencia bancaria con los siguientes datos:
        </p>
        
        @if($bankAccounts && $bankAccounts->first())
            @foreach($bankAccounts as $account)
                <div style="background: #fff; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                    <p style="font-weight: 600; margin-bottom: 0.5rem;">{{ $account->bank_name }}</p>
                    <p style="color: #666; font-size: 0.9rem;">Titular: {{ $account->account_holder }}</p>
                    <p style="color: #666; font-size: 0.9rem;">CLABE: <strong>{{ $account->clabe }}</strong></p>
                    @if($account->account_number)
                        <p style="color: #666; font-size: 0.9rem;">Cuenta: <strong>{{ $account->account_number }}</strong></p>
                    @endif
                </div>
            @endforeach
            
            <div style="background: #fff; padding: 1rem; border-radius: 4px;">
                <p style="color: #1565c0; font-weight: 600; margin-bottom: 0.5rem;">Concepto de pago:</p>
                <p style="font-family: monospace; background: #f5f5f5; padding: 0.5rem; border-radius: 4px;">
                    Pago pedido {{ $order->order_number }}
                </p>
            </div>
        @endif
        
        <p style="color: #1565c0; font-size: 0.9rem; margin-top: 1rem;">
            Una vez recibido tu pago, te enviaremos un email de confirmación.
        </p>
    </div>
    
    <!-- Próximos Pasos -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">📋 Próximos Pasos</h2>
        
        <ol style="color: #666; line-height: 1.8; margin-left: 1.5rem;">
            <li style="margin-bottom: 1rem;">
                <strong>Realiza la transferencia bancaria</strong> con el monto exacto y el concepto indicado arriba
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Carga el comprobante</strong> en tu cuenta para acelerar la confirmación
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Espera confirmación</strong> de nuestro equipo (máximo 24 horas hábiles)
            </li>
            <li>
                <strong>Recibe tu pedido</strong> en la dirección indicada dentro de los plazos establecidos
            </li>
        </ol>
    </div>
    
    <!-- Botones de Acción -->
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary" style="padding: 1rem 2rem;">
            Ver Orden Completa
        </a>
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="padding: 1rem 2rem;">
            Continuar Comprando
        </a>
    </div>
    
    <!-- Contacto -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 1.5rem; text-align: center; margin-top: 2rem;">
        <p style="color: #666; margin-bottom: 0.5rem;">¿Tienes preguntas?</p>
        <p style="margin-bottom: 1rem;">
            <a href="https://wa.me/5215512345678" target="_blank" style="color: #25d366; font-weight: 600; text-decoration: none;">
                💬 Contáctanos por WhatsApp
            </a>
        </p>
        <p style="font-size: 0.9rem; color: #999;">
            Te enviaremos un email de confirmación con todos los detalles de tu orden.
        </p>
    </div>
</div>

@endsection
