<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Número de Orden',
            'Cliente',
            'Email',
            'Teléfono',
            'Total',
            'Estado',
            'Fecha',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->user->name,
            $order->user->email,
            $order->user->phone,
            '$' . number_format($order->total, 2),
            $order->getStatusLabel(),
            $order->created_at->format('d/m/Y H:i'),
        ];
    }
}
