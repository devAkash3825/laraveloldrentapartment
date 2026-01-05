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
        Schema::create('dashboard_c_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('renter_title')->nullable();
            $table->text('renter_text')->nullable();
            $table->string('renter_image')->nullable();
            
            $table->string('manager_title')->nullable();
            $table->text('manager_text')->nullable();
            $table->string('manager_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_c_m_s');
    }
};
