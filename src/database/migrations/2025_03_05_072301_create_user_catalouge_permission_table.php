<?php

use App\Models\Permission;
use App\Models\UserCatalouge;
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
        Schema::create('user_catalouge_permission', function (Blueprint $table) {
            $table->foreignIdFor(UserCatalouge::class, 'user_catalouge_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Permission::class, 'permission_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_catalouge_permission');
    }
};
