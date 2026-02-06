<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfume_collection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfume_collection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['perfume_collection_id', 'perfume_id'], 'collection_perfume_unique');
            $table->index(['perfume_collection_id', 'position'], 'collection_position_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfume_collection_items');
    }
};
