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
            $table->integer('is_own_inventory')->comment('0=No,1=Yes')->default(1)->after('status');
            $table->unsignedBigInteger('investor_id')->nullable()->after('is_own_inventory');
            $table->foreign('investor_id')->references('id')->on('users');
            $table->double('investor_percentage', 12, 2)->nullable()->after('investor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('is_own_inventory');
            $table->dropForeign(['investor_id']);
            $table->dropColumn('investor_id');
            $table->dropColumn('investor_percentage');
        });
    }
};
