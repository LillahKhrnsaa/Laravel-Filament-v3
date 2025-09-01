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
        Schema::create('posts', function (Blueprint $table) {
            // Kolom dasar sesuai gambar
            $table->id(); // Shortcut untuk bigIncrements('id')
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('preview')->nullable(); 
            $table->longText('content');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('posts');
    }
};
