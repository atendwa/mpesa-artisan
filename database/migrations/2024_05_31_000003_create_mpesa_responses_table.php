<?php

use Atendwa\MpesaArtisan\Models\MpesaTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('mpesa_responses', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(MpesaTransaction::class)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mpesa_responses');
    }
};
