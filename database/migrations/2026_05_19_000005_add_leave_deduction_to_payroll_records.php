<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll_records', function (Blueprint $table) {
            $table->decimal('leave_deduction', 12, 2)->default(0)->after('allowances');
            $table->unsignedSmallInteger('leave_days_taken')->default(0)->after('leave_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('payroll_records', function (Blueprint $table) {
            $table->dropColumn(['leave_deduction', 'leave_days_taken']);
        });
    }
};
