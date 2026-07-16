<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            abort_unless(auth('admin')->user()->isSuperAdmin(), 403, 'Solo un super administrador puede acceder a la configuración.');
            return $next($request);
        });
    }

    public function index(): View
    {
        $general = Setting::where('group', 'general')->pluck('value', 'key');
        $social = Setting::where('group', 'social')->pluck('value', 'key');
        $email = Setting::where('group', 'email')->pluck('value', 'key');
        $bankAccounts = BankAccount::all();

        return view('admin.settings.index', [
            'general' => $general,
            'social' => $social,
            'email' => $email,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'support_email' => 'required|email',
            'support_phone' => 'required|string',
            'whatsapp' => 'required|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'mail_from_name' => 'required|string',
            'mail_from_address' => 'required|email',
            'shipping_cost' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated as $key => $value) {
            $group = $this->getSettingGroup($key);
            Setting::set($key, $value, $group);
        }

        \App\Models\AuditLog::create([
            'admin_user_id' => auth('admin')->id(),
            'action' => 'update',
            'model_type' => Setting::class,
            'model_id' => 0,
            'changes' => ['keys' => array_keys($validated)],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Configuración actualizada correctamente');
    }

    public function bankAccounts(): View
    {
        $bankAccounts = BankAccount::all();

        return view('admin.settings.bank-accounts', ['bankAccounts' => $bankAccounts]);
    }

    public function addBankAccount(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'clabe' => 'required|string|max:20|unique:bank_accounts,clabe',
            'swift_code' => 'nullable|string|max:20',
            'instructions' => 'nullable|string',
        ]);

        $bankAccount = BankAccount::create($validated);

        \App\Models\AuditLog::log('create', $bankAccount, ['bank_name' => $bankAccount->bank_name]);

        return redirect()->route('admin.settings.bank-accounts')
            ->with('success', 'Cuenta bancaria agregada correctamente');
    }

    public function updateBankAccount(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'clabe' => 'required|string|max:20|unique:bank_accounts,clabe,' . $bankAccount->id,
            'swift_code' => 'nullable|string|max:20',
            'instructions' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bankAccount->update($validated);

        \App\Models\AuditLog::log('update', $bankAccount, ['bank_name' => $bankAccount->bank_name]);

        return redirect()->route('admin.settings.bank-accounts')
            ->with('success', 'Cuenta bancaria actualizada correctamente');
    }

    public function deleteBankAccount(BankAccount $bankAccount)
    {
        \App\Models\AuditLog::log('delete', $bankAccount, ['bank_name' => $bankAccount->bank_name]);
        $bankAccount->delete();

        return redirect()->route('admin.settings.bank-accounts')
            ->with('success', 'Cuenta bancaria eliminada correctamente');
    }

    private function getSettingGroup($key)
    {
        $groups = [
            'site_name' => 'general',
            'site_tagline' => 'general',
            'support_email' => 'general',
            'support_phone' => 'general',
            'whatsapp' => 'social',
            'instagram' => 'social',
            'facebook' => 'social',
            'mail_from_name' => 'email',
            'mail_from_address' => 'email',
            'shipping_cost' => 'shipping',
            'free_shipping_threshold' => 'shipping',
            'tax_percentage' => 'tax',
        ];

        return $groups[$key] ?? 'general';
    }
}
