@extends('layouts.client')

@section('title', 'Mis Órdenes - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2.5rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    @include('client.profile._sidebar')

    <!-- Contenido Principal -->
    <main>
        <h1 style="font-size: 1.9rem; margin-bottom: 2rem;">📦 Mis Órdenes</h1>

        @if($orders->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($orders as $order)
                    <div class="card" style="padding: 1.75rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <p class="text-muted" style="font-size: 0.9rem;">Orden</p>
                                <h2 style="font-size: 1.4rem; font-family: monospace;">{{ $order->order_number }}</h2>
                            </div>

                            <div style="text-align: right;">
                                <p class="text-muted" style="font-size: 0.9rem;">Total</p>
                                <p style="font-size: 1.4rem; font-weight: 700;">$ {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border);">
                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Fecha</p>
                                <p style="font-weight: 600;">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Productos</p>
                                <p style="font-weight: 600;">{{ $order->items->count() }} items</p>
                            </div>

                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Estado</p>
                                @php
                                    $statusClass = match(true) {
                                        $order->status === 'pending_payment' => 'badge-warning',
                                        in_array($order->status, ['payment_confirmed', 'delivered']) => 'badge-success',
                                        $order->status === 'cancelled' => 'badge-danger',
                                        default => 'badge-muted',
                                    };
                                @endphp
                                <span class="badge-pill {{ $statusClass }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.75rem;">Productos:</p>
                            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.4rem;">
                                @foreach($order->items->take(3) as $item)
                                    <li class="text-muted" style="font-size: 0.9rem;">{{ $item->product->name }} × {{ $item->quantity }}</li>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <li class="text-muted" style="font-size: 0.85rem;">+{{ $order->items->count() - 3 }} más</li>
                                @endif
                            </ul>
                        </div>

                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary" style="padding: 0.65rem 1.4rem;">
                                Ver Detalles →
                            </a>

                            @if($order->status === 'pending_payment' || $order->status === 'proof_received')
                                <a href="{{ route('order.payment', $order->id) }}" class="btn btn-secondary" style="padding: 0.65rem 1.4rem;">
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
            <div class="card" style="text-align: center; padding: 4rem 2rem;">
                <p style="font-size: 1.1rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">📦 Aún no tienes órdenes</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                    Explorar Productos
                </a>
            </div>
        @endif
    </main>
</div>

@endsection
