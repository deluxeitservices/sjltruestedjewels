<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('product_price_snapshots', function(Blueprint $t){
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->decimal('price_gbp',12,2);
            $t->decimal('spot_gbp_per_g',12,6);
            $t->timestamp('as_of');
            $t->timestamps();
            $t->index(['product_id','as_of']);
        });
    }
    public function down(): void { Schema::dropIfExists('product_price_snapshots'); }
};
