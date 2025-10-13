<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // If you *really* want the typo "addresss_id", use this instead:
            $table->unsignedInteger('address_id')->default(0);
            $table->text('order_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // If you added the FK:
            $table->dropConstrainedForeignId('address_id'); // drops FK + column

            // If you used "addresss_id" instead:
            // $table->dropColumn('addresss_id');

            $table->dropColumn('order_note');
        });
    }
};
