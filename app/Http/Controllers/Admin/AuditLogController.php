<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            abort_unless(auth('admin')->user()->isSuperAdmin(), 403, 'Solo un super administrador puede ver el registro de auditoría.');
            return $next($request);
        });
    }

    public function index(Request $request): View
    {
        $query = AuditLog::with('adminUser')->latest();

        if ($request->get('action')) {
            $query->where('action', $request->get('action'));
        }

        if ($request->get('model_type')) {
            $query->where('model_type', $request->get('model_type'));
        }

        $logs = $query->paginate(30);

        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $modelTypes = AuditLog::select('model_type')->distinct()->pluck('model_type');

        return view('admin.audit-logs.index', [
            'logs' => $logs,
            'actions' => $actions,
            'modelTypes' => $modelTypes,
        ]);
    }
}
