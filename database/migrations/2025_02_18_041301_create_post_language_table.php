<?php

use App\Models\Language;
use App\Models\Post;
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
        Schema::create('post_language', function (Blueprint $table) {
            $table->foreignIdFor(Post::class, 'post_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Language::class, 'language_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_language');
    }
};
