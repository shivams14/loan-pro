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
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('name')->nullable();
            $table->bigInteger('category_id')->default('0');	
            $table->bigInteger('inventory_type_id')->default('0');	
            $table->string('status')->nullable()->default('idea');

            $table->longText('street')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('country_id')->default('0');	
            $table->bigInteger('state_id')->default('0');	
            $table->bigInteger('zipcode')->default('0');	
            $table->string('phone_number')->nullable();	

            $table->bigInteger('bedroom')->default('0');	
            $table->bigInteger('bathroom')->default('0');	
            $table->bigInteger('square_footage')->default('0');	
            $table->bigInteger('lot_area')->default('0');	
            $table->string('lot_area_type')->nullable()->default('acrea');
            $table->double('price');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
