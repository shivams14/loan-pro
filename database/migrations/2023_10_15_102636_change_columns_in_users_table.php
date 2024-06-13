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
            $table->integer('user_role')->nullable(false)->default(2)->comment('1=SuperAdmin,2=Client,3=Family')->change();
            $table->integer('active_status')->nullable(false)->default(1)->comment('1=Enable,0=Disable')->change();
            $table->integer('gender')->comment('1=Male,0=Female')->change();
            $table->bigInteger('phone_number')->change();
            $table->renameColumn('is_celular', 'is_cellular');
            $table->integer('phone_verify_status')->comment('1=Verified,0=Not verified')->change();
            $table->integer('email_verify_status')->comment('1=Verified,0=Not verified')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_role')->nullable()->default('client')->comment('')->change();
            $table->string('active_status')->nullable()->default(NULL)->comment('')->change();
            $table->string('gender')->comment('')->change();
            $table->string('phone_number')->change();
            $table->renameColumn('is_cellular', 'is_celular');
            $table->string('phone_verify_status')->comment('')->change();
            $table->string('email_verify_status')->comment('')->change();
        });
    }
};
