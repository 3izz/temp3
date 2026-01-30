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
        // Drop old pivot table if it exists
        Schema::dropIfExists('course_plan');
        
        // Remove course_id foreign key from pricing_plans table if it exists
        if (Schema::hasColumn('pricing_plans', 'course_id')) {
            Schema::table('pricing_plans', function (Blueprint $table) {
                // Try to drop foreign key if it exists
                try {
                    $table->dropForeign(['course_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
                $table->dropColumn('course_id');
            });
        }

        // Create new pivot table
        if (!Schema::hasTable('course_pricing_plan')) {
            Schema::create('course_pricing_plan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
                $table->foreignId('pricing_plan_id')->constrained('pricing_plans')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_pricing_plan');
        
        Schema::create('course_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
        });
    }
};
