<?php
// database/migrations/2025_09_27_000001_create_sell_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sell_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('sell_inquiry_id')->constrained()->cascadeOnDelete();

            // Selectable catalog item (optional) OR custom fields
            $t->unsignedBigInteger('catalog_item_id')->nullable(); // if you later add a products table

            $t->string('metal')->nullable(); // gold/silver/platinum/palladium
            $t->string('item_label')->nullable(); // e.g., "50g Perth Mint Investment Gold Bar (999.9)"
            $t->string('purity_label')->nullable(); // e.g., "24ct (99.99%)"
            $t->decimal('purity_factor', 6, 5)->nullable(); // e.g., 0.9999, 0.916, 0.750

            $t->unsignedInteger('qty')->default(1);
            $t->decimal('weight_g', 12, 3)->default(0); // per item weight in grams
            $t->decimal('total_weight_g', 12, 3)->default(0); // qty * weight_g for snapshot

            $t->decimal('unit_price', 14, 2)->default(0);  // calculated snapshot per item (one unit)
            $t->decimal('line_total', 14, 2)->default(0);  // unit_price * qty

            // Upload (one image per line item)
            $t->string('photo_path')->nullable();

            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sell_items');
    }
};
