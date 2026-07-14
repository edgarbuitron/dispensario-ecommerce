@extends('layouts.client')

@section('title', 'Checkout - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">📋 Checkout</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        
        <!-- Formulario -->
        <form method="POST" action="{{ route('checkout.process') }}" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem;">
            @csrf
            
            <!-- Dirección de Envío -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem;">📍 Dirección de Envío</h2>
                
                @if($addresses->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                        @foreach($addresses as $addr)
                            <label style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; border: 2px solid #e9ecef; border-radius: 4px; cursor: pointer; transition: all 0.3s;">
                                <input type="radio" name="address_id" value="{{ $addr->id }}" 
                                       {{ $loop->first ? 'checked' : '' }} style="margin-top: 0.25rem;">
                                <div>
                                    <p style="font-weight: 600;">{{ $addr->label ?? 'Dirección' }}</p>
                                    <p style="color: #666; font-size: 0.9rem;">{{ $addr->getFullAddress() }}</p>
                                    <p style="color: #999; font-size: 0.85rem;">📞 {{ $addr->phone }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
                
                <p style="color: #666; margin-bottom: 1rem;">
                    <a href="{{ route('profile.addresses.create') }}" style="color: #000; font-weight: 600;">+ Agregar Nueva Dirección</a>
                </p>
            </section>
            
            <hr style="border: none; border-top: 2px solid #e9ecef; margin: 2rem 0;">
            
            <!-- Método de Pago -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem;">💳 Método de Pago</h2>
                
                <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid #000; border-radius: 4px; cursor: pointer;">
                    <input type="radio" name="payment_method" value="bank_transfer" checked style="width: 20px; height: 20px;">
                    <div>
                        <p style="font-weight: 600;">Transferencia Bancaria</p>
                        <p style="color: #666; font-size: 0.9rem;">Detalles de cuenta disponibles después de confirmación</p>
                    </div>
                </label>
            </section>
            
            <hr style="border: none; border-top: 2px solid #e9ecef; margin: 2rem 0;">
            
            <!-- Envío -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem;">📦 Envío</h2>
                
                <div style="background: #d1ecf1; color: #0c5460; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                    <p style="margin: 0;">✓ Envío a CDMX: 3-5 días hábiles - $80</p>
                    <p style="margin: 0;">✓ Otros estados: 5-10 días - $150</p>
                </div>
                
                <label style="display: flex; gap: 1rem; padding: 1rem; border: 2px solid #e9ecef; border-radius: 4px; cursor: pointer;">
                    <input type="radio" name="shipping" value="80" checked>
                    <span>Envío Estándar a CDMX: $80</span>
                </label>
                
                <label style="display: flex; gap: 1rem; padding: 1rem; border: 2px solid #e9ecef; border-radius: 4px; cursor: pointer;">
                    <input type="radio" name="shipping" value="150">
                    <span>Envío a Otros Estados: $150</span>
                </label>
            </section>
            
            <hr style="border: none; border-top: 2px solid #e9ecef; margin: 2rem 0;">
            
            <!-- Notas -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem;">📝 Notas Adicionales</h2>
                
                <textarea name="notes" placeholder="Notas especiales para tu orden (opcional)" 
                          style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; resize: vertical; min-height: 100px;"></textarea>
            </section>
            
            <!-- Botón -->
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-weight: 600; font-size: 1rem;">
                Confirmar Orden
            </button>
        </form>
        
        <!-- Resumen -->
        <aside>
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; position: sticky; top: 20px;">
                <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Resumen</h2>
                
                @if($cart && $cart->items->count() > 0)
                    <div style="max-height: 300px; overflow-y: auto; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e9ecef;">
                        @foreach($cart->items as $item)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                                <strong>${{ number_format($item->subtotal, 2) }}</strong>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                    <span>Subtotal:</span>
                    <strong>${{ number_format($cart->subtotal, 2) }}</strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                    <span>Envío:</span>
                    <strong id="shipping-cost">$80</strong>
                </div>
                
                @if($cart->discount)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; color: #28a745;">
                        <span>Descuento:</span>
                        <strong>-${{ number_format($cart->discount, 2) }}</strong>
                    </div>
                @endif
                
                <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700;" id="total-section">
                    <span>Total:</span>
                    <strong>${{ number_format($cart->subtotal + 80 - ($cart->discount ?? 0), 2) }}</strong>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    // Actualizar total cuando cambia el envío
    document.querySelectorAll('input[name="shipping"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const shipping = parseFloat(this.value);
            const subtotal = {{ $cart->subtotal }};
            const discount = {{ $cart->discount ?? 0 }};
            const total = subtotal + shipping - discount;
            
            document.getElementById('shipping-cost').textContent = '$' + shipping.toFixed(2);
            
            const totalElement = document.querySelector('#total-section strong');
            totalElement.textContent = '$' + total.toFixed(2);
        });
    });
</script>

@endsection
