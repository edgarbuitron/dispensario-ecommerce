@extends('layouts.admin')

@section('title', 'Cuentas Bancarias - Administración')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">🏦 Cuentas Bancarias</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-dark">⚙️ Configuración General</a>
</div>

@if($bankAccounts->count() > 0)
    <div class="row mb-4">
        @foreach($bankAccounts as $account)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0">{{ $account->bank_name }}</h5>
                            <span class="badge bg-{{ $account->is_active ? 'success' : 'secondary' }}">
                                {{ $account->is_active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                        <p class="mb-1"><strong>Titular:</strong> {{ $account->account_holder }}</p>
                        <p class="mb-1"><strong>Cuenta:</strong> {{ $account->account_number }}</p>
                        <p class="mb-1"><strong>CLABE:</strong> {{ $account->clabe }}</p>
                        @if($account->swift_code)
                            <p class="mb-1"><strong>SWIFT:</strong> {{ $account->swift_code }}</p>
                        @endif
                        @if($account->instructions)
                            <p class="text-muted small mb-3">{{ $account->instructions }}</p>
                        @endif

                        <details>
                            <summary class="btn btn-sm btn-secondary">✏️ Editar</summary>
                            <form method="POST" action="{{ route('admin.settings.bankAccounts.update', $account->id) }}" class="mt-3">
                                @csrf @method('PUT')
                                <div class="mb-2">
                                    <label class="form-label small">Banco</label>
                                    <input type="text" name="bank_name" class="form-control form-control-sm" value="{{ $account->bank_name }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Titular</label>
                                    <input type="text" name="account_holder" class="form-control form-control-sm" value="{{ $account->account_holder }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Número de cuenta</label>
                                    <input type="text" name="account_number" class="form-control form-control-sm" value="{{ $account->account_number }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">CLABE</label>
                                    <input type="text" name="clabe" class="form-control form-control-sm" value="{{ $account->clabe }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">SWIFT (opcional)</label>
                                    <input type="text" name="swift_code" class="form-control form-control-sm" value="{{ $account->swift_code }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Instrucciones</label>
                                    <textarea name="instructions" class="form-control form-control-sm" rows="2">{{ $account->instructions }}</textarea>
                                </div>
                                <div class="mb-2 form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $account->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small">Activa</label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                            </form>
                        </details>

                        <form method="POST" action="{{ route('admin.settings.bankAccounts.delete', $account->id) }}" onsubmit="return confirm('¿Eliminar esta cuenta?');" class="mt-2">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted mb-4">No hay cuentas bancarias registradas todavía.</p>
@endif

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">➕ Agregar cuenta bancaria</h5>
        <form method="POST" action="{{ route('admin.settings.bankAccounts.add') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Banco</label>
                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titular</label>
                    <input type="text" name="account_holder" class="form-control" value="{{ old('account_holder') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Número de cuenta</label>
                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">CLABE</label>
                    <input type="text" name="clabe" class="form-control" value="{{ old('clabe') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SWIFT (opcional)</label>
                    <input type="text" name="swift_code" class="form-control" value="{{ old('swift_code') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Instrucciones para el cliente</label>
                <textarea name="instructions" class="form-control" rows="2">{{ old('instructions') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">✅ Agregar Cuenta</button>
        </form>
    </div>
</div>

@endsection
