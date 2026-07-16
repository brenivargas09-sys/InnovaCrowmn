<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 20)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('city', 50)->nullable();
            $table->enum('id_type', ['INE', 'Pasaporte', 'Licencia', 'Otro'])->default('INE');
            $table->string('id_number', 30);
            $table->string('nationality', 50)->default('Mexicana');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
