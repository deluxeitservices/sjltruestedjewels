<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jewellery_tab_master', function (Blueprint $table) {
            $table->unsignedInteger('dont_know')->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('jewellery_tab_master', function (Blueprint $table) {
            $table->dropColumn(['dont_know']);
        });
    }
};
