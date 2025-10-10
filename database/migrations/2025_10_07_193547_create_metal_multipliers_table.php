<?php

// database/migrations/2025_01_01_000000_create_metal_multipliers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('metal_multipliers', function (Blueprint $t) {
      $t->id();
      $t->string('key')->unique();           // e.g. gold_jewellery
      $t->decimal('multiplier', 6, 4);       // e.g. 0.9900
      $t->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('metal_multipliers');
  }
};
