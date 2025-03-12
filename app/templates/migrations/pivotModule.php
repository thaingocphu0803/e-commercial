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
        Schema::create('{moduleName}_catalouge_{moduleName}', function (Blueprint $table) {
            $table->foreignId('{moduleName}_catalouge_id')->constrained('{moduleName}_catalouges')->cascadeOnDelete();
            $table->foreignId('{moduleName}_id')->constrained('{moduleName}s')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{moduleName}_catalouge_{moduleName}');
    }
};
