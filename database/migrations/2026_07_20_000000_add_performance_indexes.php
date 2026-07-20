<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            if (! Schema::hasColumn('meetings', 'scheduled_at')) return;
            $table->index('scheduled_at', 'meetings_scheduled_at_idx');
        });

        Schema::table('meeting_minutes', function (Blueprint $table) {
            if (! Schema::hasTable('meeting_minutes')) return;
            $table->index('created_at', 'meeting_minutes_created_at_idx');
            $table->index('meeting_id', 'meeting_minutes_meeting_id_idx');
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (! Schema::hasTable('attendances')) return;
            $table->index(['created_at', 'status'], 'attendances_created_status_idx');
        });

        Schema::table('committee_members', function (Blueprint $table) {
            if (! Schema::hasTable('committee_members')) return;
            $table->index('committee_id', 'committee_members_committee_id_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasTable('users')) return;
            $table->index('created_at', 'users_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            if (Schema::hasTable('meetings')) {
                $table->dropIndex('meetings_scheduled_at_idx');
            }
        });

        Schema::table('meeting_minutes', function (Blueprint $table) {
            if (Schema::hasTable('meeting_minutes')) {
                $table->dropIndex('meeting_minutes_created_at_idx');
                $table->dropIndex('meeting_minutes_meeting_id_idx');
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasTable('attendances')) {
                $table->dropIndex('attendances_created_status_idx');
            }
        });

        Schema::table('committee_members', function (Blueprint $table) {
            if (Schema::hasTable('committee_members')) {
                $table->dropIndex('committee_members_committee_id_idx');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasTable('users')) {
                $table->dropIndex('users_created_at_idx');
            }
        });
    }
};
