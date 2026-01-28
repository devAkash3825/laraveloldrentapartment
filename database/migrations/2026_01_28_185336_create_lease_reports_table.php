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
        Schema::create('lease_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('renter_id')->nullable();
            $table->text('username')->nullable(); // Name on lease
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('apt')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->date('movedate')->nullable();
            $table->string('lengthlease')->nullable();
            $table->string('rentamount')->nullable();
            $table->string('namecommunityorlandlords')->nullable();
            $table->string('landlordtelephone')->nullable();
            $table->string('assisted_by')->nullable();
            $table->integer('status')->default(0); // 0: Pending, 1: Approved, 2: Rejected
            $table->timestamps();

            $table->foreign('renter_id')->references('Id')->on('login')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_reports');
    }
};
