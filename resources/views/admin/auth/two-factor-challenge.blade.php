@extends("layouts.client")

@section("title", "Verificación en dos pasos")

@section("content")
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-2">🔐 Verificación en dos pasos</h2>
                    <p class="text-center text-muted mb-4">Ingresa el código de 6 dígitos de tu app de autenticación.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.two-factor.verify') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Código</label>
                            <input type="text" name="code" class="form-control text-center" style="font-size: 1.5rem; letter-spacing: 0.3em;"
                                   inputmode="numeric" pattern="[0-9]*" maxlength="6" autofocus required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Verificar</button>
                    </form>

                    <hr>

                    <p class="text-center text-muted">
                        <a href="{{ route('admin.login') }}">Cancelar e iniciar sesión de nuevo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
