<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('meeting_id')->unique();
            $table->unsignedBigInteger('recorded_by_id');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->longText('content');
            $table->text('summary')->nullable();
            $table->json('decisions')->nullable();
            $table->json('action_items')->nullable();
            $table->date('next_meeting_date')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->foreign('recorded_by_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('approved_by_id')->references('id')->on('members')->onDelete('set null');
            $table->index('is_approved');
            $table->index('is_published');
            $table->fullText('content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_minutes');
    }
};
