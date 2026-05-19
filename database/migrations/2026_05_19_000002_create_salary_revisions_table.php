<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salary_structure_id')->constrained()->cascadeOnDelete();
            $table->decimal('old_basic', 12, 2)->default(0);
            $table->decimal('new_basic', 12, 2)->default(0);
            $table->decimal('old_hra', 12, 2)->default(0);
            $table->decimal('new_hra', 12, 2)->default(0);
            $table->decimal('old_allowances', 12, 2)->default(0);
            $table->decimal('new_allowances', 12, 2)->default(0);
            $table->decimal('old_net', 12, 2)->default(0);
            $table->decimal('new_net', 12, 2)->default(0);
            $table->date('effective_from');
            $table->string('reason')->nullable();
            $table->foreignId('revised_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_revisions');
    }
};
