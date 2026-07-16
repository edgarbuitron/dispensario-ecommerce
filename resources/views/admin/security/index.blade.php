@extends('layouts.admin')

@section('title', 'Seguridad')

@section('content')

<h1 class="mb-4">🔐 Seguridad</h1>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Verificación en dos pasos</h5></div>
            <div class="card-body">
                @if($enabled)
                    <p class="text-success fw-semibold">✅ La verificación en dos pasos está activada en tu cuenta.</p>
                    <p class="text-muted small">Se activó el {{ $admin->two_factor_confirmed_at->format('d/m/Y H:i') }}.</p>

                    <hr>

                    <form method="POST" action="{{ route('admin.security.disable') }}" onsubmit="return confirm('¿Seguro que quieres desactivar la verificación en dos pasos?');">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Confirma tu contraseña para desactivarla</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-outline-danger">Desactivar 2FA</button>
                    </form>
                @else
                    <p class="text-muted">Protege tu cuenta con un código adicional generado por una app como Google Authenticator, Authy o Microsoft Authenticator.</p>

                    <ol class="text-muted">
                        <li class="mb-2">Escanea este código QR con tu app de autenticación.</li>
                        <li class="mb-2">Ingresa el código de 6 dígitos que te muestre para confirmar.</li>
                    </ol>

                    <div id="qrcode" class="my-3"></div>

                    <p class="small text-muted">¿No puedes escanear? Ingresa este código manualmente: <code>{{ $secret }}</code></p>

                    <form method="POST" action="{{ route('admin.security.enable') }}" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Código de verificación</label>
                            <input type="text" name="code" class="form-control" style="max-width: 200px; font-size: 1.2rem; letter-spacing: 0.2em;"
                                   inputmode="numeric" pattern="[0-9]*" maxlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Activar 2FA</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@if(!$enabled)
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById('qrcode'), {
            text: @json($qrUrl),
            width: 200,
            height: 200,
        });
    </script>
@endif

@endsection
