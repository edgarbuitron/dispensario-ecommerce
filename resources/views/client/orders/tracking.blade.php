@extends('layouts.client')

@section('title', 'Seguimiento de Orden ' . $order->order_number . ' - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; max-width: 700px;">

    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">📦 Seguimiento de tu Orden</h1>
        <p style="color: var(--color-text-muted);">Orden <strong>{{ $order->order_number }}</strong></p>
    </div>

    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
        @if($tracking->count() > 0)
            <div style="display: flex; flex-direction: column;">
                @foreach($tracking as $index => $event)
                    <div style="display: flex; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 16px; height: 16px; border-radius: 50%; background: {{ $index === 0 ? 'var(--color-accent)' : '#ccc' }}; flex-shrink: 0;"></div>
                            @if(!$loop->last)
                                <div style="width: 2px; flex: 1; background: var(--color-border); min-height: 40px;"></div>
                            @endif
                        </div>
                        <div style="padding-bottom: 2rem;">
                            <p style="font-weight: 700; {{ $index === 0 ? 'color: var(--color-accent);' : '' }}">
                                {{ \App\Models\Order::make(['status' => $event->status])->getStatusLabel() }}
                            </p>
                            @if($event->message)
                                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-top: 0.25rem;">{{ $event->message }}</p>
                            @endif
                            <p style="color: var(--color-text-muted); font-size: 0.8rem; margin-top: 0.25rem;">{{ $event->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: var(--color-text-muted); text-align: center;">Todavía no hay actualizaciones de seguimiento para esta orden.</p>
        @endif
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Orden Completa</a>
        @if($order->status === 'pending_payment')
            <a href="{{ route('order.payment', $order) }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Ir a Pagar</a>
        @endif
    </div>
</div>

@endsection
