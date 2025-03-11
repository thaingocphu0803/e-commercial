<?php

use App\Models\{ModuleName};
use App\Models\{ModuleName}Catalouge;
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
            $table->foreignIdFor({ModuleName}Catalouge::class, '{moduleName}_catalouge_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor({ModuleName}::class, '{moduleName}_id')->constrained()->cascadeOnDelete();
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
