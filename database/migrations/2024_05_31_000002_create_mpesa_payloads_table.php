<?php

use Atendwa\MpesaArtisan\Models\MpesaTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('mpesa_payloads', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(MpesaTransaction::class)->index();
            $table->string('party_a')->nullable();
            $table->string('party_b')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('reference')->nullable();
            $table->string('short_code')->nullable();
            $table->string('command_id')->nullable();
            $table->string('remarks')->nullable();
            $table->string('occasion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mpesa_payloads');
    }
};
