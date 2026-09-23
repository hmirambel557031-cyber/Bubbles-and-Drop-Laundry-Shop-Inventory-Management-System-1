<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->unsignedInteger('quantity')
                ->default(0)
                ->change();

            $table->unsignedInteger('max_capacity')
                ->default(100)
                ->change();

            $table->unsignedInteger('reorder_level')
                ->default(10)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->decimal('quantity', 10, 2)
                ->default(0)
                ->change();

            $table->decimal('max_capacity', 10, 2)
                ->default(100)
                ->change();

            $table->decimal('reorder_level', 10, 2)
                ->default(10)
                ->change();
        });
    }
};