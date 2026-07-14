@extends('layouts.admin')

@section('title', 'Verificar Comprobantes de Pago')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">💳 Comprobantes de Pago</h1>
    
    <div style="display: flex; gap: 1rem;">
        <span style="display: inline-block; background: #ffc107; color: #000; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
            ⏳ {{ $pendingCount }} pendientes
        </span>
        <span style="display: inline-block; background: #28a745; color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
            ✓ {{ $approvedCount }} aprobados
        </span>
    </div>
</div>

<!-- Filtros -->
<div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.proofs.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar orden..."
               style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
        
        <select name="status" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Todos los estados</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendientes</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobados</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazados</option>
        </select>
        
        <button type="submit" class="btn btn-secondary">🔍 Filtrar</button>
        <a href="{{ route('admin.proofs.index') }}" class="btn btn-secondary">Limpiar</a>
    </form>
</div>

<!-- Comprobantes Pendientes (Prioridad) -->
@if($pendingProofs->count() > 0)
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; color: #ffc107;">⏳ Pendientes de Aprobación</h2>
        
        <div style="display: grid; gap: 1.5rem;">
            @foreach($pendingProofs as $proof)
                <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; border-left: 4px solid #ffc107;">
                    
                    <!-- Header -->
                    <div style="padding: 1.5rem; background: #fff9e6;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Orden</p>
                                <p style="font-weight: 700;">{{ $proof->order->order_number }}</p>
                            </div>
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Cliente</p>
                                <p style="font-weight: 600;">{{ $proof->order->user->name }}</p>
                            </div>
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Total</p>
                                <p style="font-weight: 700; color: #28a745;">${{ number_format($proof->order->total, 2) }}</p>
                            </div>
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Recibido</p>
                                <p style="font-weight: 600;">{{ $proof->created_at->format('d/m/y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido -->
                    <div style="padding: 1.5rem; display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
                        
                        <!-- Info -->
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">📧 Email del cliente</p>
                            <p style="font-weight: 600; margin-bottom: 1.5rem;">{{ $proof->order->user->email }}</p>
                            
                            @if($proof->reference)
                                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Referencia de transferencia</p>
                                <p style="font-family: monospace; background: #f8f9fa; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem;">
                                    {{ $proof->reference }}
                                </p>
                            @endif
                            
                            @if($proof->notes)
                                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">📝 Notas del cliente</p>
                                <p style="background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                                    {{ $proof->notes }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Imagen -->
                        @if($proof->image_path)
                            <div>
                                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Comprobante</p>
                                <img src="{{ asset('storage/proofs/' . $proof->image_path) }}" 
                                     style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; cursor: pointer;"
                                     onclick="window.open(this.src, '_blank')">
                                <p style="color: #999; font-size: 0.8rem; text-align: center; margin-top: 0.5rem;">Click para ampliar</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Acciones -->
                    <div style="padding: 1.5rem; background: #f8f9fa; border-top: 1px solid #e9ecef; display: flex; gap: 1rem;">
                        <form method="POST" action="{{ route('admin.proofs.approve', $proof->id) }}" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem; font-weight: 600;">
                                ✅ APROBAR TRANSFERENCIA
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-danger" style="padding: 0.75rem 1.5rem; font-weight: 600;"
                                onclick="document.getElementById('reject-{{ $proof->id }}').style.display='block'">
                            ❌ RECHAZAR
                        </button>
                    </div>
                    
                    <!-- Modal Rechazo (oculto) -->
                    <div id="reject-{{ $proof->id }}" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;">
                        <div style="background: #fff; padding: 2rem; border-radius: 8px; max-width: 500px; width: 90%;">
                            <h3 style="font-weight: 700; margin-bottom: 1rem;">Razón de rechazo</h3>
                            
                            <form method="POST" action="{{ route('admin.proofs.reject', $proof->id) }}">
                                @csrf
                                
                                <textarea name="rejection_reason" required placeholder="Explica por qué se rechaza este comprobante..."
                                          style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; min-height: 120px; margin-bottom: 1rem;"></textarea>
                                
                                <div style="display: flex; gap: 1rem;">
                                    <button type="submit" class="btn btn-danger" style="flex: 1;">Confirmar rechazo</button>
                                    <button type="button" class="btn btn-secondary" style="flex: 1;"
                                            onclick="document.getElementById('reject-{{ $proof->id }}').style.display='none'">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Comprobantes Aprobados -->
@if($approvedProofs->count() > 0)
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; color: #28a745;">✅ Aprobados</h2>
        
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Cliente</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600;">Total</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Aprobado</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvedProofs as $proof)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;"><strong>{{ $proof->order->order_number }}</strong></td>
                            <td style="padding: 1rem;">{{ $proof->order->user->name }}</td>
                            <td style="text-align: right; padding: 1rem; font-weight: 600;">${{ number_format($proof->order->total, 2) }}</td>
                            <td style="text-align: center; padding: 1rem;">{{ $proof->updated_at->format('d/m/y') }}</td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="{{ route('admin.orders.show', $proof->order->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    Ver →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- Comprobantes Rechazados -->
@if($rejectedProofs->count() > 0)
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; color: #dc3545;">❌ Rechazados</h2>
        
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Cliente</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Razón</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Rechazado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejectedProofs as $proof)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;"><strong>{{ $proof->order->order_number }}</strong></td>
                            <td style="padding: 1rem;">{{ $proof->order->user->name }}</td>
                            <td style="padding: 1rem;">
                                <span style="display: block; color: #666; font-size: 0.9rem; max-width: 300px;">
                                    {{ $proof->rejection_reason }}
                                </span>
                            </td>
                            <td style="text-align: center; padding: 1rem;">{{ $proof->updated_at->format('d/m/y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@if($allProofs->count() === 0)
    <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.1rem; color: #666;">No hay comprobantes para revisar</p>
    </div>
@endif

@endsection
