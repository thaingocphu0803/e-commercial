<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attr_catalouge_attr', function (Blueprint $table) {
            $table->foreignId('attr_catalouge_id')->constrained('attr_catalouges')->cascadeOnDelete();
            $table->foreignId('attr_id')->constrained('attrs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attr_catalouge_attr');
    }
};
