<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('colocation_id')
                ->constrained('colocations')
                ->cascadeOnDelete();

            $table->string('name', 80);
            $table->string('color', 20)->default('#fb923c');
            $table->timestamps();


            $table->unique(['colocation_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
