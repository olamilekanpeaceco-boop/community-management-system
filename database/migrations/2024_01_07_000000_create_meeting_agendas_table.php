<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_agendas', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('meeting_id');
            $table->tinyInteger('item_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('presenter_id')->nullable();
            $table->integer('estimated_duration_minutes')->default(15);
            $table->json('discussion_points')->nullable();
            $table->string('materials_url')->nullable();
            $table->enum('status', ['pending', 'in_discussion', 'completed', 'deferred'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->foreign('presenter_id')->references('id')->on('members')->onDelete('set null');
            $table->index('meeting_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_agendas');
    }
};
