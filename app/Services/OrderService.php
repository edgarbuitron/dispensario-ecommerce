<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Address;
use App\Events\OrderCreated;
use Auth;

class OrderService
{
    public function createOrder($data)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->isEmpty()) {
            return ['success' => false, 'message' => 'El carrito está vacío'];
        }

        $address = Address::findOrFail($data['address_id']);

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'order_number' => $this->generateOrderNumber(),
            'status' => 'pending_payment',
            'payment_method' => $data['payment_method'],
            'subtotal' => $cart->subtotal,
            'tax' => $cart->tax ?? 0,
            'shipping' => $data['shipping'] ?? 0,
            'discount' => $cart->discount ?? 0,
            'total' => $cart->total + ($data['shipping'] ?? 0),
            'coupon_code' => $cart->coupon_code,
            'notes' => $data['notes'] ?? null,
        ]);

        // Copiar items del carrito a la orden
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_sku' => $item->product->sku,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'subtotal' => $item->subtotal,
                'product_attributes' => json_encode($item->product->attributes->pluck('attribute_value', 'attribute_name')),
            ]);
        }

        // Registrar primer estado
        $order->tracking()->create([
            'status' => 'pending_payment',
            'message' => 'Pedido realizado. Esperando comprobante de pago.',
        ]);

        // Limpiar carrito
        $cart->clear();

        // Disparar evento
        event(new OrderCreated($order));

        return ['success' => true, 'order' => $order];
    }

    public function generateOrderNumber()
    {
        $year = date('Y');
        $lastOrder = Order::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastOrder ? intval(substr($lastOrder->order_number, -6)) + 1 : 1;
        
        return 'ORD-' . $year . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    }

    public function updateOrderStatus($orderId, $status, $notes = null)
    {
        $order = Order::findOrFail($orderId);
        
        $order->update([
            'status' => $status,
            'admin_notes' => $notes ?? $order->admin_notes,
        ]);

        $order->tracking()->create([
            'status' => $status,
            'message' => $this->getStatusMessage($status),
        ]);

        event(new \App\Events\OrderStatusChanged($order));

        return $order;
    }

    public function uploadProof($orderId, $file)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            return ['success' => false, 'message' => 'No tienes permiso'];
        }

        if ($order->status !== 'pending_payment') {
            return ['success' => false, 'message' => 'Esta orden no está en estado de pago pendiente'];
        }

        $filename = 'proof_' . $order->id . '_' . time() . '.' . $file->extension();
        $file->storeAs('proofs', $filename, 'public');

        $order->proofs()->create([
            'image_path' => $filename,
            'status' => 'pending',
        ]);

        $order->update(['status' => 'proof_received']);
        $order->tracking()->create([
            'status' => 'proof_received',
            'message' => 'Comprobante de pago recibido. En revisión.',
        ]);

        return ['success' => true, 'message' => 'Comprobante subido correctamente'];
    }

    public function approveProof($proofId, $notes = null)
    {
        $proof = \App\Models\OrderProof::findOrFail($proofId);
        $proof->approve($notes);
        
        return ['success' => true, 'message' => 'Pago confirmado'];
    }

    public function rejectProof($proofId, $notes)
    {
        $proof = \App\Models\OrderProof::findOrFail($proofId);
        $proof->reject($notes);
        
        return ['success' => true, 'message' => 'Comprobante rechazado'];
    }

    public function getStatusMessage($status)
    {
        $messages = [
            'pending_payment' => 'Pedido realizado. Esperando comprobante de pago.',
            'proof_received' => 'Comprobante de pago recibido. En revisión.',
            'payment_confirmed' => 'Pago confirmado. Iniciando preparación.',
            'preparing' => 'Tu pedido está siendo preparado.',
            'ready_to_ship' => 'Pedido listo para envío.',
            'shipped' => 'Tu pedido está en camino.',
            'delivered' => 'Pedido entregado correctamente.',
            'cancelled' => 'Pedido cancelado.',
        ];

        return $messages[$status] ?? '';
    }
}
