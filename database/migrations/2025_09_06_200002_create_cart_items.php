<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function(Blueprint $t){
            $t->id();
            $t->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('quantity')->default(1);
            $t->decimal('locked_price_gbp',12,2)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cart_items'); }
};
