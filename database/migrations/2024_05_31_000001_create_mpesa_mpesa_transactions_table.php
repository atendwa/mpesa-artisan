<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('mpesa_transactions', function (Blueprint $table): void {
            $table->id();
            $table->string('type')->index()->nullable();
            $table->string('merchant_request_id')->index()->nullable();
            $table->string('checkout_request_id')->index()->nullable();
            $table->string('originator_conversation_id')->index()->nullable();
            $table->string('conversation_id')->index()->nullable();

            $table->string('response_code')->nullable();
            $table->string('response_description')->nullable();
            $table->string('result_code')->nullable();
            $table->string('result_desc')->nullable();

            $table->string('transaction_id')->index()->nullable();

            $table->string('error_code')->nullable();
            $table->string('error_message')->nullable();

            $table->boolean('is_completed');
            $table->timestamp('response_received_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mpesa_transactions');
    }
};
