<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // From your form
            $t->string('name');                 // addr_name
            $t->string('phone')->nullable();   // addr_phone
            $t->string('address')->nullable(); // address (freeform, if you want to keep a single line too)
            $t->string('house_no')->nullable();
            $t->string('street_name')->nullable();
            $t->string('city');
            $t->string('postal_code');
            $t->string('country')->nullable();

            $t->boolean('default_address')->default(false); // “make default” flag

            $t->timestamps();
            $t->index(['user_id', 'default_address']); // helps fetch default quickly
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
