<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderStatusChangedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusChangedNotification
{
    public function handle(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $statusLabel = $order->getStatusLabel();

        // Enviar email al cliente
        Mail::to($order->user->email)
            ->send(new OrderStatusChangedMail($order));

        // Crear notificación en base de datos
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'type' => 'order_status_changed',
            'subject' => 'Actualización de orden: ' . $order->order_number,
            'message' => 'El estado de tu orden ha cambiado a: ' . $statusLabel,
            'channel' => 'email',
            'data' => json_encode(['status' => $order->status]),
            'sent_at' => now(),
        ]);
    }
}
