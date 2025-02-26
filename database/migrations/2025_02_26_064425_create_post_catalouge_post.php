<?php

use App\Models\Post;
use App\Models\PostCatalouge;
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
        Schema::create('post_catalouge_post', function (Blueprint $table) {
            $table->foreignIdFor(PostCatalouge::class, 'post_catalouge_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Post::class, 'post_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalouge_post');
    }
};
