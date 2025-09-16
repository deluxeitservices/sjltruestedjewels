<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('carts', function(Blueprint $t){
            $t->id();
            $t->string('session_id')->index();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->enum('status',['open','locked','completed','expired'])->default('open');
            $t->timestamp('lock_expires_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('carts'); }
};
