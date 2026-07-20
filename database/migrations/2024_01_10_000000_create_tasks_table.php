<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->unsignedBigInteger('committee_id')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('completion_notes')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable();
            $table->date('recurrence_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('assigned_to_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('set null');
            $table->index('assigned_to_id');
            $table->index('status');
            $table->index('priority');
            $table->index('due_date');
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
