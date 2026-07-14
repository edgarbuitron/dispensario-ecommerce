<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('label')->nullable(); // Casa, Oficina, etc.
            $table->string('recipient_name');
            $table->string('phone');
            $table->string('street_address');
            $table->string('reference')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country')->default('Mexico');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_billing')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
