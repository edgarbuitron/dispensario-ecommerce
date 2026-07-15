@extends('layouts.client')

@section('title', 'Historial - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    @include('client.profile._sidebar')

    <main>
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">🕓 Historial de Actividad</h1>

        @php $orders = $user->orders()->latest()->get(); @endphp

        @if($orders->count() > 0)
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                                <th style="text-align: left; padding: 1rem; font-weight: 600;">Fecha</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                                <th style="text-align: right; padding: 1rem; font-weight: 600;">Total</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 1rem; font-family: monospace;">{{ $order->order_number }}</td>
                                    <td style="padding: 1rem;">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <span style="background: #f8f9fa; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ $order->getStatusLabel() }}</span>
                                    </td>
                                    <td style="text-align: right; padding: 1rem; font-weight: 600;">${{ number_format($order->total, 2) }}</td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
                <p style="color: #666; margin-bottom: 1.5rem;">Todavía no tienes órdenes registradas</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary">Explorar Catálogo</a>
            </div>
        @endif
    </main>
</div>

@endsection
