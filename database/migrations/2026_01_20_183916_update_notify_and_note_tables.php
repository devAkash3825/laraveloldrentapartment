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
        if (Schema::hasTable('notifydetails')) {
            Schema::table('notifydetails', function (Blueprint $table) {
                if (!Schema::hasColumn('notifydetails', 'agent_id')) {
                    $table->unsignedBigInteger('agent_id')->nullable()->after('property_id');
                }
                if (!Schema::hasColumn('notifydetails', 'notified_at')) {
                    $table->timestamp('notified_at')->nullable()->after('agent_id');
                }
                if (!Schema::hasColumn('notifydetails', 'responded_at')) {
                    $table->timestamp('responded_at')->nullable()->after('notified_at');
                }
            });
        }

        if (Schema::hasTable('notedetails')) {
            Schema::table('notedetails', function (Blueprint $table) {
                if (!Schema::hasColumn('notedetails', 'referral_id')) {
                    $table->unsignedBigInteger('referral_id')->nullable()->after('note_id');
                }
                if (!Schema::hasColumn('notedetails', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('referral_id');
                }
                if (!Schema::hasColumn('notedetails', 'sender_id')) {
                    $table->unsignedBigInteger('sender_id')->nullable()->after('parent_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notifydetails')) {
            Schema::table('notifydetails', function (Blueprint $table) {
                $table->dropColumn(['agent_id', 'notified_at', 'responded_at']);
            });
        }
        if (Schema::hasTable('notedetails')) {
            Schema::table('notedetails', function (Blueprint $table) {
                $table->dropColumn(['referral_id', 'parent_id', 'sender_id']);
            });
        }
    }
};
