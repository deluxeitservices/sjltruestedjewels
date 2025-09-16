<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('products', function(Blueprint $t){
            $t->id();
            $t->string('slug')->unique();
            $t->string('title');
            $t->string('brand')->nullable();
            $t->enum('metal',['XAU','XAG','XPT','XPD'])->default('XAU');
            $t->enum('type',['bar','coin'])->default('bar');
            $t->decimal('weight_g',10,3);
            $t->decimal('fineness',6,3)->default(999.9);
            $t->boolean('vat_exempt')->default(true);
            $t->string('image_url')->nullable();
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
