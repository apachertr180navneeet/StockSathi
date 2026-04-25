<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('basic_salary', 15, 2)->default(0.00);
            $table->decimal('allowances', 15, 2)->default(0.00);
            $table->decimal('deductions', 15, 2)->default(0.00);
            $table->decimal('net_salary', 15, 2)->default(0.00);
            $table->date('payment_date')->nullable();
            $table->enum('payment_status', ['Pending', 'Paid'])->default('Pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
