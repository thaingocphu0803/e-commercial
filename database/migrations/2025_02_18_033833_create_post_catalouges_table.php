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
        Schema::create('post_catalouges', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('album')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->integer('order')->default(0);
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalouges');
    }
};
