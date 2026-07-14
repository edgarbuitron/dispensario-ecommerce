<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('type')->nullable(); // Vape, Cartucho, Flor, etc.
            $table->string('flavor')->nullable();
            $table->string('presentation')->nullable(); // 1g, 2g, etc.
            $table->enum('stock_status', ['available', 'low', 'out_of_stock', 'hidden'])->default('available');
            $table->string('sku')->unique();
            $table->integer('quantity_sold')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(true);
            $table->timestamp('featured_until')->nullable();
            $table->timestamp('new_until')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['category_id', 'brand_id']);
            $table->index('slug');
            $table->index('sku');
            $table->index('stock_status');
        });

        // SQLite (used for local development) does not support FULLTEXT indexes.
        // MySQL keeps the index used by the catalog search in production.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('products', function (Blueprint $table) {
                $table->fullText(['name', 'description']);
            });
        }

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('product_id');
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('attribute_name');
            $table->string('attribute_value');
            $table->timestamps();
            
            $table->unique(['product_id', 'attribute_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
