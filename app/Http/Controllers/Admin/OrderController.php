<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderShipment;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth:admin');
        $this->orderService = $orderService;
    }

    public function index(Request $request): View
    {
        $query = Order::with(['user', 'address'])->latest();

        if ($request->get('search')) {
            $query->where('order_number', 'like', '%' . $request->get('search') . '%')
                  ->orWhereHas('user', function ($q) {
                      $q->where('email', 'like', '%' . $request->get('search') . '%');
                  });
        }

        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->get('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->get('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'address', 'items', 'proofs', 'shipment', 'tracking']);

        return view('admin.orders.show', ['order' => $order]);
    }

    public function approveProof(Request $request, Order $order)
    {
        if ($order->status !== 'proof_received') {
            return back()->with('error', 'Esta orden no tiene comprobante pendiente');
        }

        $proof = $order->proofs()->where('status', 'pending')->first();
        
        if (!$proof) {
            return back()->with('error', 'No hay comprobante pendiente');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $this->orderService->approveProof($proof->id, $validated['notes'] ?? null);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Comprobante aprobado');
    }

    public function rejectProof(Request $request, Order $order)
    {
        if ($order->status !== 'proof_received') {
            return back()->with('error', 'Esta orden no tiene comprobante pendiente');
        }

        $proof = $order->proofs()->where('status', 'pending')->first();
        
        if (!$proof) {
            return back()->with('error', 'No hay comprobante pendiente');
        }

        $validated = $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $this->orderService->rejectProof($proof->id, $validated['notes']);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Comprobante rechazado');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:payment_confirmed,preparing,ready_to_ship,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $this->orderService->updateOrderStatus(
            $order->id,
            $validated['status'],
            $validated['notes'] ?? null
        );

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado de la orden actualizado');
    }

    public function addShipment(Request $request, Order $order)
    {
        if ($order->status !== 'ready_to_ship') {
            return back()->with('error', 'La orden debe estar lista para envío');
        }

        $validated = $request->validate([
            'carrier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100|unique:order_shipments,tracking_number',
            'tracking_url' => 'nullable|url',
            'notes' => 'nullable|string|max:500',
        ]);

        OrderShipment::create([
            'order_id' => $order->id,
            'carrier' => $validated['carrier'],
            'tracking_number' => $validated['tracking_number'],
            'tracking_url' => $validated['tracking_url'],
            'notes' => $validated['notes'],
            'shipped_date' => now(),
        ]);

        $this->orderService->updateOrderStatus($order->id, 'shipped');

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Información de envío agregada');
    }

    public function export(Request $request)
    {
        $query = Order::latest();

        if ($request->get('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->get('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }

        $orders = $query->get();

        return \Excel::download(new \App\Exports\OrdersExport($orders), 'ordenes.xlsx');
    }
}
