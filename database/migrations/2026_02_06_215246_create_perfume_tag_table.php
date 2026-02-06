<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfume_tag', function (Blueprint $table) {
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['perfume_id', 'tag_id']);
            $table->index(['tag_id', 'perfume_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfume_tag');
    }
};
