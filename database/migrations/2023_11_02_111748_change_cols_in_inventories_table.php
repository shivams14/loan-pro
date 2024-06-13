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
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('total_acres');
            $table->dropColumn('total_cost');
            $table->dropColumn('per_acre_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->double('price')->nullable()->default(NULL)->after('lot_area_type');
            $table->double('total_acres')->nullable()->default(NULL)->after('price');
            $table->double('total_cost')->nullable()->default(NULL)->after('cost_of_development');
            $table->double('per_acre_cost')->nullable()->default(NULL)->after('total_cost');
        });
    }
};
