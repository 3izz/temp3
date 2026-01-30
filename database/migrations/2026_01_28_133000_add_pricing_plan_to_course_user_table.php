<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add pricing_plan_id to track which package the course enrollment belongs to
     */
    public function up(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            // Add pricing_plan_id to track package subscriptions
            $table->foreignId('pricing_plan_id')->nullable()->after('course_id')
                ->constrained('pricing_plans')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['user_id', 'pricing_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropForeign(['pricing_plan_id']);
            $table->dropColumn('pricing_plan_id');
        });
    }
};
