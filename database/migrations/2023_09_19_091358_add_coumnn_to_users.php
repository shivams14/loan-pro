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
        Schema::table('users', function (Blueprint $table) {
            //$table->bigIncrements('id')->first();

            $table->softDeletes();

            $table->string('first_name', 80)->after('name')->nullable();
			$table->string('middle_name', 80)->after('first_name')->nullable();
			$table->string('last_name', 80)->after('middle_name')->nullable();			
			
            $table->string('user_role')->nullable()->default('client');
            $table->string('active_status')->nullable();
            $table->bigInteger('client_type_id')->default(0);
            $table->string('language')->nullable()->default('en');

            $table->string('gender')->nullable();
			$table->string('dob')->nullable();
            $table->string('login_type')->nullable()->default('user');
			$table->string('country_code')->nullable();
			$table->string('phone_number')->nullable();
            $table->string('avatar')->nullable();
            $table->bigInteger('parent_id')->default(0);

			$table->string('device_type')->nullable();
			$table->string('address')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
			$table->bigInteger('country_id')->default(0);
			$table->bigInteger('state_id')->default(0);
			$table->string('zipcode')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();


            $table->json('allowed_payment_method')->nullable();

			$table->string('pin')->nullable();
			$table->string('otp')->nullable();
            $table->string('token')->nullable();

			$table->string('email_activate_key')->nullable();
			$table->string('password_reset_key')->nullable();

			$table->string('phone_verify_status')->nullable();
			$table->string('email_verify_status')->nullable();
			$table->string('email_start_time')->nullable();
			$table->string('email_end_time')->nullable();			
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
