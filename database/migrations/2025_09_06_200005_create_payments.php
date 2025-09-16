<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->string('provider')->default('stripe');
            $t->string('intent_id')->nullable();
            $t->decimal('amount_gbp',12,2)->default(0);
            $t->string('currency',3)->default('GBP');
            $t->string('status')->default('created');
            $t->json('raw_response')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
