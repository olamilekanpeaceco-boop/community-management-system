<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->unsignedBigInteger('author_id');
            $table->enum('memo_type', ['general', 'urgent', 'confidential', 'announcement'])->default('general');
            $table->enum('recipient_type', ['all_members', 'committee', 'specific_members', 'roles'])->default('all_members');
            $table->unsignedBigInteger('committee_id')->nullable();
            $table->json('target_role_ids')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('published_by_id')->nullable();
            $table->integer('version')->default(1);
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('published_by_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
            $table->index('status');
            $table->index('is_published');
            $table->fullText(['title', 'content']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
