<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->decimal('amount', 10, 2);
            $table->string('bank');
            $table->string('cheque_number')->unique();
            $table->date('date');
            $table->enum('status', ['en_attente', 'valide', 'refuse'])->default('en_attente');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};