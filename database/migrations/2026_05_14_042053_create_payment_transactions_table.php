<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('payroll_record_id')->nullable();
            $table->string('transaction_reference')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer', 'cheque', 'cash'])->default('bank_transfer');
            $table->enum('status', ['initiated', 'processing', 'success', 'failed', 'reversed'])->default('initiated');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('remarks')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};