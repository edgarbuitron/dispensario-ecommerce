<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        
        return view('client.profile.index', ['user' => $user]);
    }

    public function edit(): View
    {
        $user = Auth::user();
        
        return view('client.profile.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Perfil actualizado correctamente');
    }

    public function addresses(): View
    {
        $addresses = Auth::user()->addresses()->where('is_active', true)->get();
        
        return view('client.profile.addresses', ['addresses' => $addresses]);
    }

    public function addressCreate(): View
    {
        return view('client.profile.address-form');
    }

    public function addressStore(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();

        $address = Address::create($validated);

        if ($request->get('is_default')) {
            $address->markAsDefault();
        }

        return redirect()->route('profile.addresses')
            ->with('success', 'Dirección agregada correctamente');
    }

    public function addressEdit(Address $address): View
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('client.profile.address-form', ['address' => $address]);
    }

    public function addressUpdate(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'nullable|boolean',
        ]);

        $address->update($validated);

        if ($request->get('is_default')) {
            $address->markAsDefault();
        }

        return redirect()->route('profile.addresses')
            ->with('success', 'Dirección actualizada correctamente');
    }

    public function addressDelete(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->update(['is_active' => false]);

        return redirect()->route('profile.addresses')
            ->with('success', 'Dirección eliminada correctamente');
    }

    public function history(): View
    {
        $user = Auth::user();
        
        return view('client.profile.history', ['user' => $user]);
    }
}
