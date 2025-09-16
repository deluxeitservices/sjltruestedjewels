<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('order_items', function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->string('metal',3);
            $t->decimal('weight_g',10,3);
            $t->unsignedInteger('qty')->default(1);
            $t->decimal('unit_price_gbp',12,2);
            $t->decimal('vat_rate',5,4)->default(0);
            $t->decimal('vat_gbp',12,2)->default(0);
            $t->decimal('line_total_gbp',12,2);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('order_items'); }
};
