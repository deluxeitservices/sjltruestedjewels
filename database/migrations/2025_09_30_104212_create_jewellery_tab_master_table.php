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
        Schema::create('jewellery_tab_master', function (Blueprint $table) {
            $table->id(); // Assuming your table has an auto-increment primary key
            $table->unsignedBigInteger('user_id')->default(0);
            $table->text('notes')->nullable();
            $table->decimal('total_grams', 12, 3)->default(0.000);
            $table->decimal('total_points', 12, 3)->default(0.000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jewellery_tab_master');
    }
};
