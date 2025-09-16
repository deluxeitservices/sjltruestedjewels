<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('metal_quotes', function(Blueprint $t){
            $t->id();
            $t->string('metal');
            $t->string('currency');
            $t->decimal('bid',12,4);
            $t->decimal('ask',12,4);
            $t->decimal('mid',12,4);
            $t->decimal('per_gram',12,6);
            $t->timestamp('as_of');
            $t->timestamps();
            $t->index(['metal','currency','as_of']);
        });
    }
    public function down(): void { Schema::dropIfExists('metal_quotes'); }
};
