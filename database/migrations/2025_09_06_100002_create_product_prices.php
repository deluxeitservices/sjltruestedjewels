<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('product_prices', function(Blueprint $t){
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->decimal('premium_pct',8,4)->default(0.0250);
            $t->decimal('premium_flat',10,2)->default(0);
            $t->enum('side',['sell','buy'])->default('sell');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('product_prices'); }
};
