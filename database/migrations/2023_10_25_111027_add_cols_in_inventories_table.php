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
            $table->renameColumn('country_id', 'county');
            $table->double('total_acres')->nullable()->default(NULL)->after('price');
            $table->integer('cost_of_development')->nullable()->default(NULL)->comment('1=total_cost,2=per_acre_cost')->after('total_acres');
            $table->double('total_cost')->nullable()->default(NULL)->after('cost_of_development');
            $table->double('per_acre_cost')->nullable()->default(NULL)->after('total_cost');
            $table->integer('lot_area_type')->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->renameColumn('county', 'country_id');
            $table->dropColumn('total_acres');
            $table->dropColumn('cost_of_development');
            $table->dropColumn('total_cost');
            $table->dropColumn('per_acre_cost');
            $table->integer('lot_area_type')->nullable(false)->default(NULL)->change();
        });
    }
};
