<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('file_path')->unique();
            $table->string('file_name');
            $table->string('file_type', 50);
            $table->integer('file_size');
            $table->string('mime_type');
            $table->unsignedBigInteger('uploaded_by_id');
            $table->unsignedBigInteger('committee_id')->nullable();
            $table->enum('document_type', ['policy', 'procedure', 'memo', 'report', 'form', 'minutes', 'other'])->default('other');
            $table->string('category')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->enum('access_level', ['public', 'members_only', 'committee_only', 'restricted'])->default('members_only');
            $table->integer('download_count')->default(0);
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('uploaded_by_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
            $table->foreign('approved_by_id')->references('id')->on('members')->onDelete('set null');
            $table->index('document_type');
            $table->index('access_level');
            $table->index('is_archived');
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
