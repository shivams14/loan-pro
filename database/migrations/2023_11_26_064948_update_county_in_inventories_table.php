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
            $table->bigInteger('inventory_type_id')->nullable(false)->default(null)->change();
            $table->string('county')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->bigInteger('inventory_type_id')->nullable(false)->default(0)->change();
            $table->string('county')->nullable(false)->change();
        });
    }
};
