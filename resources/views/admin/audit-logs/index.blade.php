@extends('layouts.admin')

@section('title', 'Registro de Auditoría')

@section('content')

<h1 class="mb-4">🕵️ Registro de Auditoría</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="action" class="form-select" onchange="this.form.submit()">
                    <option value="">Todas las acciones</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ $action }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <select name="model_type" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos los tipos</option>
                    @foreach($modelTypes as $type)
                        <option value="{{ $type }}" {{ request('model_type') === $type ? 'selected' : '' }}>{{ class_basename($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary w-100">Limpiar filtros</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Admin</th>
                    <th>Acción</th>
                    <th>Modelo</th>
                    <th>Detalles</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $log->adminUser->name ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                        <td>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</td>
                        <td class="small text-muted">
                            @if($log->changes)
                                {{ json_encode($log->changes) }}
                            @endif
                        </td>
                        <td class="small text-muted">{{ $log->ip_address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Todavía no hay actividad registrada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $logs->links() }}</div>

@endsection
