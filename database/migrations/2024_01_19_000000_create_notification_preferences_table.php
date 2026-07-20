<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->unique();
            $table->boolean('email_on_new_announcement')->default(true);
            $table->boolean('email_on_meeting_reminder')->default(true);
            $table->boolean('email_on_task_assigned')->default(true);
            $table->boolean('email_on_memo_published')->default(true);
            $table->boolean('email_on_new_document')->default(false);
            $table->boolean('email_on_comment_reply')->default(true);
            $table->boolean('push_notifications_enabled')->default(true);
            $table->boolean('in_app_notifications_enabled')->default(true);
            $table->enum('notification_frequency', ['immediate', 'daily', 'weekly'])->default('immediate');
            $table->boolean('quiet_hours_enabled')->default(false);
            $table->time('quiet_hours_start')->nullable();
            $table->time('quiet_hours_end')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
