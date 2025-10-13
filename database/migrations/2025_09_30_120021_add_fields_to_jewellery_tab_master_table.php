<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jewellery_tab_master', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(0)->after('id');
            $table->text('notes')->nullable()->after('user_id');
            $table->decimal('total_grams', 12, 3)->default(0)->after('notes');
            $table->decimal('total_points', 12, 3)->default(0)->after('total_grams');
        });
    }

    public function down(): void
    {
        Schema::table('jewellery_tab_master', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'notes', 'total_grams', 'total_points']);
        });
    }
};
