<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fragrance_family_id')->constrained()->restrictOnDelete();
            $table->foreignId('concentration_id')->constrained()->restrictOnDelete();
            $table->foreignId('occasion_id')->constrained()->restrictOnDelete();
            $table->foreignId('intensity_id')->constrained()->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('code', 30)->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->json('top_notes')->nullable();
            $table->json('heart_notes')->nullable();
            $table->json('base_notes')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedSmallInteger('fixation_min_hours')->nullable();
            $table->unsignedSmallInteger('fixation_max_hours')->nullable();
            $table->string('projection', 20)->nullable();
            $table->string('audience', 30)->default('unissex');
            $table->unsignedSmallInteger('score')->default(0);
            $table->unsignedSmallInteger('release_order')->default(0);
            $table->unsignedSmallInteger('best_seller_rank')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new_release')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'release_order']);
            $table->index(['fragrance_family_id', 'concentration_id', 'occasion_id', 'intensity_id'], 'perfumes_filter_index');
            $table->index(['price', 'is_active']);
            $table->index(['best_seller_rank', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfumes');
    }
};
