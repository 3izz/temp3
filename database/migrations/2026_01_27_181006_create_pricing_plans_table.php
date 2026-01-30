<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // College Program / Employee Program ...
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // 20000 / 50000 / 75000

            $table->enum('target_type', ['group', 'individual']);
            $table->enum('delivery_mode', ['one_to_many', 'one_on_one']);
            $table->enum('schedule_type', ['fixed', 'choose', 'flexible']);

            $table->boolean('is_popular')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
