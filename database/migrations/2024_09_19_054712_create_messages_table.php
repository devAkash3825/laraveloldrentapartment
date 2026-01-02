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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propertyId');
            $table->unsignedBigInteger('renterId');  // The sender (renter, manager, or admin)
            $table->unsignedBigInteger('adminId');  // The sender (renter, manager, or admin)
            $table->unsignedBigInteger('managerId');  // The sender (renter, manager, or admin)
            $table->unsignedBigInteger('notify_manager');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
