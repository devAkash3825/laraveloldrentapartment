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
        Schema::table('renter_info', function (Blueprint $table) {
            $table->string('new_rental_adddress')->nullable();
            $table->string('unit')->nullable();
            $table->string('rent_amount')->nullable();
            $table->string('landloard')->nullable();
            $table->boolean('ready_to_invoice')->default(0);
            $table->date('LeaseEndDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renter_info', function (Blueprint $table) {
            $table->dropColumn(['new_rental_adddress', 'unit', 'rent_amount', 'landloard', 'ready_to_invoice', 'LeaseEndDate']);
        });
    }
};
