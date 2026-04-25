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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_no')->unique();
            $table->unsignedBigInteger('account_id'); // Expense Account
            $table->unsignedBigInteger('payment_account_id'); // Bank/Cash Account
            $table->decimal('amount', 15, 2);
            $table->date('expense_date');
            $table->string('reference_no')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('payment_account_id')->references('id')->on('accounts');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->string('income_no')->unique();
            $table->unsignedBigInteger('account_id'); // Revenue Account
            $table->unsignedBigInteger('payment_account_id'); // Bank/Cash Account
            $table->decimal('amount', 15, 2);
            $table->date('income_date');
            $table->string('reference_no')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('payment_account_id')->references('id')->on('accounts');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income');
        Schema::dropIfExists('expenses');
    }
};
