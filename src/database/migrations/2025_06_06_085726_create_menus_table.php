<?php

use App\Models\User;
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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_catalouge_id')->constrained('menu_catalouges')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('album')->nullable();
            $table->string('type', 20)->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->integer('order')->default(0);
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->nestedSet();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
