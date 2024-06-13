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
            $table->integer('status')->nullable(false)->default(NULL)->comment('0=Idea,1=Ready,2=Inprogress,3=Completed')->change();
            $table->string('country_id')->default(NULL)->change();
            $table->renameColumn('phone_number', 'parcel_number');
            $table->integer('lot_area_type')->nullable(false)->default(NULL)->comment('1=Acres,2=Square Feet')->change();
            $table->bigInteger('zipcode')->nullable()->default(NULL)->change();
            $table->bigInteger('bedroom')->nullable()->default(NULL)->change();
            $table->bigInteger('bathroom')->nullable()->default(NULL)->change();
            $table->bigInteger('square_footage')->nullable()->default(NULL)->change();
            $table->bigInteger('lot_area')->nullable()->default(NULL)->change();
            $table->double('price')->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('status')->nullable()->default('idea')->comment('')->change();
            $table->bigInteger('country_id')->default(0)->change();
            $table->renameColumn('parcel_number', 'phone_number');
            $table->string('lot_area_type')->nullable()->default('acrea')->comment('')->change();
            $table->bigInteger('zipcode')->nullable(false)->default(0)->change();
            $table->bigInteger('bedroom')->nullable(false)->default(0)->change();
            $table->bigInteger('bathroom')->nullable(false)->default(0)->change();
            $table->bigInteger('square_footage')->nullable(false)->default(0)->change();
            $table->bigInteger('lot_area')->nullable(false)->default(0)->change();
            $table->double('price')->nullable(false)->default(NULL)->change();
        });
    }
};
