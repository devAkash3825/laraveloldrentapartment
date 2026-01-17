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
        Schema::create('renter_info_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('renter_info_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->json('snapshot');
            $table->timestamps();
            
            $table->foreign('renter_info_id')->references('Id')->on('renter_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renter_info_history');
    }
};
