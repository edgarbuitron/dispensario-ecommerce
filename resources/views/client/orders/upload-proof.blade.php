@extends('layouts.client')

@section('title', 'Subir Comprobante de Pago')

@section('content')

<div class="container" style="margin: 2rem auto; max-width: 800px;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">📸 Comprobante de Transferencia</h1>
    
    <!-- Información de la Orden -->
    <div style="background: #d1ecf1; color: #0c5460; padding: 1.5rem; border-radius: var(--radius-sm); margin-bottom: 2rem;">
        <h2 style="font-weight: 600; margin-bottom: 0.5rem;">Orden: {{ $order->order_number }}</h2>
        <p style="margin-bottom: 0.5rem;">Total a pagar: <strong>${{ number_format($order->total, 2) }}</strong></p>
        <p style="margin: 0; font-size: 0.9rem;">Estado: <strong>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</strong></p>
    </div>
    
    <!-- Datos Bancarios -->
    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem; margin-bottom: 2rem;">
        <h3 style="font-weight: 700; margin-bottom: 1.5rem;">💳 Datos para Transferir</h3>
        
        @if($bankAccounts && $bankAccounts->count() > 0)
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                @foreach($bankAccounts as $account)
                    <div style="border: 1px solid var(--color-border); padding: 1.5rem; border-radius: var(--radius-sm);">
                        <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Banco</p>
                        <p style="font-weight: 700; margin-bottom: 1rem;">{{ $account->bank_name }}</p>
                        
                        <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 0.25rem;">Titular</p>
                        <p style="font-weight: 600; margin-bottom: 1rem;">{{ $account->account_holder }}</p>
                        
                        <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 0.25rem;">CLABE</p>
                        <p style="font-family: monospace; background: var(--color-surface-alt); padding: 0.75rem; border-radius: var(--radius-sm); margin-bottom: 1rem; word-break: break-all;">
                            {{ $account->clabe }}
                        </p>
                        
                        @if($account->account_number)
                            <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 0.25rem;">Cuenta</p>
                            <p style="font-family: monospace; background: var(--color-surface-alt); padding: 0.75rem; border-radius: var(--radius-sm);">
                                {{ $account->account_number }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 1.5rem; border-radius: var(--radius-sm); margin-top: 1.5rem;">
                <p style="color: #856404; font-weight: 600; margin-bottom: 0.5rem;">⚠️ Concepto de Pago</p>
                <p style="color: #856404; margin: 0;">
                    Usa este concepto en tu transferencia:
                    <code style="background: #fff; padding: 0.25rem 0.5rem; border-radius: 3px;">Pago pedido {{ $order->order_number }}</code>
                </p>
            </div>
        @endif
    </div>
    
    <!-- Formulario de Upload -->
    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
        <h3 style="font-weight: 700; margin-bottom: 1.5rem;">📤 Subir Comprobante</h3>
        
        @if($order->proof)
            <div style="background: #d4edda; border-left: 4px solid var(--color-accent); padding: 1.5rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem;">
                <p style="color: #155724; font-weight: 600; margin-bottom: 0.5rem;">✓ Comprobante Recibido</p>
                <p style="color: #155724; margin-bottom: 1rem;">
                    Tu comprobante fue recibido el {{ $order->proof->created_at->format('d/m/Y H:i') }}
                </p>
                
                @if($order->proof->image_path)
                    <div style="margin-bottom: 1rem;">
                        <p style="color: #155724; font-size: 0.9rem; margin-bottom: 0.5rem;">Imagen:</p>
                        <img src="{{ asset('storage/proofs/' . $order->proof->image_path) }}" 
                             style="max-width: 300px; max-height: 300px; border-radius: var(--radius-sm); border: 1px solid var(--color-accent);">
                    </div>
                @endif
                
                @if($order->proof->status === 'pending')
                    <p style="color: #856404; background: #fff3cd; padding: 0.75rem; border-radius: var(--radius-sm); border-left: 4px solid #ffc107;">
                        ⏳ En revisión por el equipo administrativo
                    </p>
                @elseif($order->proof->status === 'approved')
                    <p style="color: #155724; background: #d4edda; padding: 0.75rem; border-radius: var(--radius-sm); border-left: 4px solid var(--color-accent);">
                        ✅ Aprobado - Tu orden será enviada pronto
                    </p>
                @elseif($order->proof->status === 'rejected')
                    <p style="color: #721c24; background: #f8d7da; padding: 0.75rem; border-radius: var(--radius-sm); border-left: 4px solid var(--color-danger);">
                        ❌ Rechazado: {{ $order->proof->rejection_reason }}
                    </p>
                    <p style="color: var(--color-text-muted); margin-top: 1rem;">Por favor, sube un nuevo comprobante.</p>
                @endif
            </div>
        @endif
        
        <form method="POST" action="{{ route('order.upload-proof', $order->id) }}" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.75rem;">Selecciona la imagen del comprobante</label>
                <div style="border: 2px dashed var(--color-border); border-radius: var(--radius-sm); padding: 2rem; text-align: center; cursor: pointer; transition: all 0.3s;"
                     onclick="document.getElementById('proof-input').click()">
                    <p style="color: var(--color-text-muted); margin: 0;">📸 Click aquí o arrastra una imagen</p>
                    <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-top: 0.5rem;">JPG, PNG (máx 5MB)</p>
                </div>
                <input type="file" id="proof-input" name="proof_image" accept="image/*" required
                       style="display: none;">
            </div>
            
            <div id="preview" style="margin-bottom: 1.5rem; display: none;">
                <p style="font-weight: 600; margin-bottom: 0.75rem;">Vista previa:</p>
                <img id="preview-img" style="max-width: 300px; max-height: 300px; border-radius: var(--radius-sm); border: 1px solid var(--color-border);">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.75rem;">Referencia de transferencia (opcional)</label>
                <input type="text" name="reference" placeholder="Ej: TR123456789"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.75rem;">Notas adicionales (opcional)</label>
                <textarea name="notes" placeholder="Cuéntanos detalles sobre la transferencia..."
                          style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); min-height: 100px;"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-weight: 600; font-size: 1rem;">
                📤 Subir Comprobante
            </button>
        </form>
        
        <p style="color: var(--color-text-muted); font-size: 0.9rem; text-align: center; margin-top: 1.5rem;">
            ⏱️ Los comprobantes se revisan dentro de 24 horas hábiles
        </p>
    </div>
    
    <!-- Botón Volver -->
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-secondary" style="padding: 0.75rem 2rem;">
            ← Volver a la Orden
        </a>
    </div>
</div>

<script>
    document.getElementById('proof-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-img').src = event.target.result;
                document.getElementById('preview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
