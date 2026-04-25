<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds soft-delete support (deleted_at column) to all core tables.
 * Models will use the SoftDeletes trait to honour this column automatically.
 */
return new class extends Migration
{
    /**
     * The tables that need a deleted_at column.
     */
    private array $tables = [
        'brands',
        'suppliers',
        'customers',
        'ware_houses',
        'product_categories',
        'products',
        'purchases',
        'return_purchases',
        'sales',
        'sale_returns',
        'transfers',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes(); // adds nullable deleted_at timestamp column
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
