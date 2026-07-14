@extends('layouts.client')

@section('title', 'Mis Órdenes - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
    
    <!-- Sidebar -->
    <aside style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; height: fit-content;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Mi Cuenta</h2>
        
        <nav style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('profile.index') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666;">👤 Mi Perfil</a>
            <a href="{{ route('profile.addresses') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666;">📍 Direcciones</a>
            <a href="{{ route('profile.orders') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; background: #000; color: #fff;">📦 Mis Órdenes</a>
        </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main>
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">📦 Mis Órdenes</h1>
        
        @if($orders->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($orders as $order)
                    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap;">
                            <div>
                                <p style="color: #666; font-size: 0.9rem;">Orden</p>
                                <h2 style="font-size: 1.5rem; font-weight: 700;">{{ $order->order_number }}</h2>
                            </div>
                            
                            <div style="text-align: right;">
                                <p style="color: #666; font-size: 0.9rem;">Total</p>
                                <p style="font-size: 1.5rem; font-weight: 700;">$ {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e9ecef;">
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Fecha</p>
                                <p style="font-weight: 600;">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                            
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Productos</p>
                                <p style="font-weight: 600;">{{ $order->items->count() }} items</p>
                            </div>
                            
                            <div>
                                <p style="color: #666; font-size: 0.85rem;">Estado</p>
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: {{ $order->status === 'pending_payment' ? '#ffc107' : ($order->status === 'payment_confirmed' ? '#28a745' : ($order->status === 'delivered' ? '#17a2b8' : '#e9ecef')) }}; color: {{ $order->status === 'pending_payment' ? '#000' : '#fff' }};">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">Productos:</p>
                            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                                @foreach($order->items->take(3) as $item)
                                    <li style="color: #666; font-size: 0.9rem;">{{ $item->product->name }} × {{ $item->quantity }}</li>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <li style="color: #999; font-size: 0.85rem;">+{{ $order->items->count() - 3 }} más</li>
                                @endif
                            </ul>
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                                Ver Detalles →
                            </a>
                            
                            @if($order->status === 'pending_payment' || $order->status === 'proof_received')
                                <a href="{{ route('order.payment', $order->id) }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">
                                    Subir Comprobante
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Paginación -->
            @if($orders->hasPages())
                <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
                    {{ $orders->links() }}
                </div>
            @endif
            
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
                <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">📦 Aún no tienes órdenes</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                    Explorar Productos
                </a>
            </div>
        @endif
    </main>
</div>

@endsection
