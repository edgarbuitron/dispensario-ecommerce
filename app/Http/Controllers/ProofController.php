<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProof;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProofController extends Controller
{
    /**
     * Cliente: Mostrar formulario para subir comprobante
     */
    public function clientUploadForm(Order $order)
    {
        // Verificar que la orden pertenece al usuario autenticado
        abort_if($order->user_id !== Auth::id(), 403);
        
        // Verificar que está pendiente de pago
        abort_if(!in_array($order->status, ['pending_payment', 'proof_received']), 400);
        
        $bankAccounts = BankAccount::where('is_active', true)->get();
        
        return view('client.orders.upload-proof', compact('order', 'bankAccounts'));
    }
    
    /**
     * Cliente: Subir comprobante de transferencia
     */
    public function clientUploadProof(Request $request, Order $order)
    {
        // Validaciones
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if(!in_array($order->status, ['pending_payment', 'proof_received']), 400);
        
        $validated = $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'reference' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);
        
        try {
            // Eliminar comprobante anterior si existe
            if ($order->proof) {
                if ($order->proof->image_path) {
                    Storage::disk('public')->delete('proofs/' . $order->proof->image_path);
                }
                $order->proof->delete();
            }
            
            // Guardar imagen
            $imageName = 'proof_' . $order->id . '_' . time() . '.' . $request->file('proof_image')->getClientOriginalExtension();
            $request->file('proof_image')->storeAs('proofs', $imageName, 'public');
            
            // Crear registro de comprobante
            $proof = OrderProof::create([
                'order_id' => $order->id,
                'image_path' => $imageName,
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending', // Pendiente de aprobación
            ]);
            
            // Cambiar estado de orden a "proof_received"
            $order->update(['status' => 'proof_received']);
            
            // TODO: Enviar email al admin notificando nuevo comprobante
            
            return redirect()->route('order.show', $order->id)
                ->with('success', '✅ Comprobante enviado exitosamente. Será revisado en 24 horas hábiles.');
            
        } catch (\Exception $e) {
            return back()
                ->with('error', '❌ Error al subir el comprobante: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Admin: Listar comprobantes pendientes y aprobados
     */
    public function adminIndex(Request $request)
    {
        $query = OrderProof::with(['order', 'order.user'])->orderBy('created_at', 'desc');
        
        // Filtros
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('order', function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%");
            });
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $allProofs = $query->get();
        $pendingProofs = $allProofs->where('status', 'pending')->values();
        $approvedProofs = $allProofs->where('status', 'approved')->values();
        $rejectedProofs = $allProofs->where('status', 'rejected')->values();
        
        $pendingCount = OrderProof::where('status', 'pending')->count();
        $approvedCount = OrderProof::where('status', 'approved')->count();
        
        return view('admin.proofs.index', compact(
            'allProofs',
            'pendingProofs',
            'approvedProofs',
            'rejectedProofs',
            'pendingCount',
            'approvedCount'
        ));
    }
    
    /**
     * Admin: Aprobar comprobante
     */
    public function approve(OrderProof $proof)
    {
        try {
            // Actualizar estado del comprobante
            $proof->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);
            
            // Actualizar estado de la orden a "payment_confirmed"
            $proof->order->update(['status' => 'payment_confirmed']);
            
            // TODO: Enviar email al cliente notificando aprobación
            // TODO: Crear entrada en historial de auditoría
            
            return redirect()->route('admin.proofs.index')
                ->with('success', '✅ Comprobante aprobado. Orden lista para preparar envío.');
            
        } catch (\Exception $e) {
            return back()
                ->with('error', '❌ Error al aprobar: ' . $e->getMessage());
        }
    }
    
    /**
     * Admin: Rechazar comprobante
     */
    public function reject(Request $request, OrderProof $proof)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        try {
            // Actualizar estado del comprobante
            $proof->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'rejected_at' => now(),
                'rejected_by' => Auth::id(),
            ]);
            
            // La orden vuelve a "pending_payment" para que el cliente pueda subir otro comprobante
            $proof->order->update(['status' => 'pending_payment']);
            
            // TODO: Enviar email al cliente con motivo del rechazo
            // TODO: Crear entrada en historial de auditoría
            
            return redirect()->route('admin.proofs.index')
                ->with('success', '❌ Comprobante rechazado. Cliente ha sido notificado para enviar uno nuevo.');
            
        } catch (\Exception $e) {
            return back()
                ->with('error', '❌ Error al rechazar: ' . $e->getMessage());
        }
    }
}
