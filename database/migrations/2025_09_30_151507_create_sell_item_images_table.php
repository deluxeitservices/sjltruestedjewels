<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sell_item_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_item_id')->index();
            $table->string('path');             // storage path (public disk)
            $table->string('original_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sell_item_images');
    }
};
