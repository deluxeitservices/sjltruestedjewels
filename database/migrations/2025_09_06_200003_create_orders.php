<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function(Blueprint $t){
            $t->id();
            $t->foreignId('cart_id')->nullable()->constrained()->nullOnDelete();
            $t->string('order_no')->unique();
            $t->enum('status',['pending','paid','failed','canceled'])->default('pending');
            $t->string('currency',3)->default('GBP');
            $t->decimal('subtotal_gbp',12,2)->default(0);
            $t->decimal('vat_gbp',12,2)->default(0);
            $t->decimal('total_gbp',12,2)->default(0);
            $t->string('customer_email')->nullable();
            $t->string('customer_name')->nullable();
            $t->string('payment_intent_id')->nullable();
            $t->string('checkout_session_id')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamp('lock_expires_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
