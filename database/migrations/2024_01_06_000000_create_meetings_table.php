<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('committee_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->enum('meeting_type', ['regular', 'special', 'emergency', 'annual'])->default('regular');
            $table->timestamp('scheduled_at');
            $table->integer('duration_minutes')->default(60);
            $table->enum('location_type', ['physical', 'virtual', 'hybrid'])->default('physical');
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('room_number', 50)->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->text('cancelled_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable();
            $table->date('recurrence_end_date')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
            $table->foreign('organizer_id')->references('id')->on('members')->onDelete('restrict');
            $table->index('scheduled_at');
            $table->index('status');
            $table->index('organizer_id');
            $table->index('committee_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
