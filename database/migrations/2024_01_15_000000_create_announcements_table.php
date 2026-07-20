<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->unsignedBigInteger('author_id');
            $table->string('category')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('visibility', ['public', 'members_only', 'committee_only'])->default('public');
            $table->unsignedBigInteger('committee_id')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('published_by_id')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'active', 'expired', 'archived'])->default('draft');
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('published_by_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
            $table->index('is_published');
            $table->index('status');
            $table->index('is_featured');
            $table->fullText(['title', 'content']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
