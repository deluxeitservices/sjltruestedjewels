<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sjl_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile', 30)->nullable();
            $table->string('email')->index();
            $table->text('message')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sjl_contacts');
    }
};
