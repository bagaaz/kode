<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfume_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->nullable()->unique();
            $table->unsignedSmallInteger('volume_ml');
            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['perfume_id', 'volume_ml']);
            $table->index(['perfume_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfume_variants');
    }
};
