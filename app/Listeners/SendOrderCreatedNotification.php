<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedNotification
{
    public function handle(OrderCreated $event): void
    {
        // Enviar email al cliente
        Mail::to($event->order->user->email)
            ->send(new OrderCreatedMail($event->order));

        // Enviar email al admin
        Mail::to(\App\Models\Setting::get('support_email', 'admin@dispensario.com'))
            ->send(new \App\Mail\OrderCreatedAdminMail($event->order));

        // Crear notificación en base de datos
        \App\Models\Notification::create([
            'user_id' => $event->order->user_id,
            'order_id' => $event->order->id,
            'type' => 'order_created',
            'subject' => 'Orden creada: ' . $event->order->order_number,
            'message' => 'Tu orden ha sido creada correctamente. Esperamos tu comprobante de pago.',
            'channel' => 'email',
            'sent_at' => now(),
        ]);
    }
}
