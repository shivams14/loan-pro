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
            $table->double('origination_fee', 12, 2)->nullable()->after('per_acre_cost');
            $table->double('closing_fee', 12, 2)->nullable()->after('origination_fee');
            $table->double('end_of_term_pro_rata', 12, 2)->nullable()->after('closing_fee');
            $table->double('total_price', 12, 2)->nullable()->after('end_of_term_pro_rata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('origination_fee');
            $table->dropColumn('closing_fee');
            $table->dropColumn('end_of_term_pro_rata');
            $table->dropColumn('total_price');
        });
    }
};
