<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // long enough for full URLs
            $table->string('product_url', 2048)->nullable()->after('external_id');
            // (optional) If you’ll query by it:
            // $table->index('product_url');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // if you added the index above, drop it first:
            // $table->dropIndex(['product_url']);
            $table->dropColumn('product_url');
        });
    }
};

