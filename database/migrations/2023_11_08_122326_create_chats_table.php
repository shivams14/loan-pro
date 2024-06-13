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
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('support_id');
            $table->foreign('support_id')->references('id')->on('supports');
            $table->unsignedBigInteger('message_from');
            $table->foreign('message_from')->references('id')->on('users');
            $table->unsignedBigInteger('message_to');
            $table->foreign('message_to')->references('id')->on('users');
            $table->longText('message');
            $table->integer('is_read')->default(0)->comment('0=Unread,1=Read');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
