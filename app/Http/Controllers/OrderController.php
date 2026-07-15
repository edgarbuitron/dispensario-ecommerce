<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\BankAccount;
use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    public function checkout(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        $addresses = Auth::user()->addresses()->where('is_active', true)->get();
        
        if ($addresses->isEmpty()) {
            return redirect()->route('profile.addresses.create')
                ->with('info', 'Por favor agrega una dirección de envío');
        }

        $bankAccounts = BankAccount::active()->get();

        return view('client.checkout.index', [
            'cart' => $cart,
            'addresses' => $addresses,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:bank_transfer',
            'notes' => 'nullable|string|max:500',
            'shipping' => 'required|numeric|min:0',
        ]);

        // Verificar que la dirección pertenece al usuario
        $address = Address::find($validated['address_id']);
        if ($address->user_id !== Auth::id()) {
            return back()->with('error', 'Dirección no válida');
        }

        $result = $this->orderService->createOrder($validated);

        if ($result['success']) {
            return redirect()->route('order.payment', ['order' => $result['order']->id])
                ->with('success', 'Orden creada correctamente');
        }

        return back()->with('error', $result['message']);
    }

    public function payment(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $bankAccounts = BankAccount::active()->get();

        return view('client.checkout.payment', [
            'order' => $order,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $result = $this->orderService->uploadProof($order->id, $validated['proof']);

        if ($result['success']) {
            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function confirmation(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('client.checkout.confirmation', ['order' => $order]);
    }

    public function myOrders(): View
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('client.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items', 'tracking', 'proofs', 'shipment']);

        return view('client.orders.show', ['order' => $order]);
    }

    public function tracking(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $tracking = $order->tracking()->latest()->get();

        return view('client.orders.tracking', [
            'order' => $order,
            'tracking' => $tracking,
        ]);
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = \PDF::loadView('client.orders.invoice', ['order' => $order]);
        
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
