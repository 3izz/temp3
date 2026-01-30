<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Update all TEACHER roles to COACH to avoid conflicts and create dedicated COACH interface
     */
    public function up(): void
    {
        // Update all existing users with 'teacher' role to 'coach'
        \DB::table('users')
            ->where('role', 'teacher')
            ->update(['role' => 'coach']);
            
        // Log the change for reference
        \Log::info('TEACHER role updated to COACH for all users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert COACH roles back to TEACHER
        \DB::table('users')
            ->where('role', 'coach')
            ->update(['role' => 'teacher']);
            
        // Log the reversal
        \Log::info('COACH role reverted back to TEACHER');
    }
};
