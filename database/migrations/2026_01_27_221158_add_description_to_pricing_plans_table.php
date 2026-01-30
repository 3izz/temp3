<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // تحقق إذا العمود غير موجود قبل الإضافة
        if (!Schema::hasColumn('pricing_plans', 'description')) {
            Schema::table('pricing_plans', function (Blueprint $table) {
                $table->text('description')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        // التراجع عن التغيير
        if (Schema::hasColumn('pricing_plans', 'description')) {
            Schema::table('pricing_plans', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
