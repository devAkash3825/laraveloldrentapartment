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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('messagesId');
            $table->unsignedBigInteger('renterId');
            $table->unsignedBigInteger('adminId');
            $table->unsignedBigInteger('managerId');
            $table->unsignedBigInteger('senderId');
            $table->unsignedBigInteger('receiverId');
            $table->unsignedBigInteger('messageId');
            $table->text('message');
            $table->timestamps();
            $table->foreign('messagesId')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
