<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        $query = Coupon::latest();

        if ($request->get('search')) {
            $query->where('code', 'like', '%' . $request->get('search') . '%');
        }

        $coupons = $query->paginate(20);

        return view('admin.coupons.index', ['coupons' => $coupons]);
    }

    public function create(): View
    {
        return view('admin.coupons.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'max_per_customer' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['code'] = strtoupper($validated['code']);

        $coupon = Coupon::create($validated);

        \App\Models\AuditLog::log('create', $coupon);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón creado correctamente');
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.coupons.form', ['coupon' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'max_per_customer' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['code'] = strtoupper($validated['code']);

        $coupon->update($validated);

        \App\Models\AuditLog::log('update', $coupon);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón actualizado correctamente');
    }

    public function destroy(Coupon $coupon)
    {
        abort_unless(auth('admin')->user()->isSuperAdmin(), 403, 'Solo un super administrador puede eliminar cupones.');

        \App\Models\AuditLog::log('delete', $coupon);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón eliminado correctamente');
    }
}
