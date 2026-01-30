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
        Schema::create('courses', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('language');
    $table->string('level'); // beginner, intermediate, advanced
    $table->string('duration')->nullable(); 
    $table->decimal('price', 8, 2)->default(0);
    $table->string('category')->nullable();
    $table->string('thumbnail')->nullable();
    $table->float('rating')->default(0);
    $table->enum('status', ['active', 'draft', 'archived'])->default('draft');
    $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
