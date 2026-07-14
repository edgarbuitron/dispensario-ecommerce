<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'pending_payment',
                'proof_received',
                'payment_confirmed',
                'preparing',
                'ready_to_ship',
                'shipped',
                'delivered',
                'cancelled'
            ]);
            $table->text('message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('created_at');
        });

        Schema::create('order_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('status');
        });

        Schema::create('order_shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('carrier')->nullable(); // FedEx, DHL, Estafeta, etc.
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->timestamp('estimated_delivery')->nullable();
            $table->timestamp('delivered_date')->nullable();
            $table->timestamps();
            
            $table->unique('tracking_number');
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_shipments');
        Schema::dropIfExists('order_proofs');
        Schema::dropIfExists('order_tracking');
    }
};
