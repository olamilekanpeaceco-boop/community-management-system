<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_minute_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('meeting_minute_id');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->uuid('uploaded_by_id')->nullable();
            $table->timestamps();

            $table->foreign('meeting_minute_id')->references('id')->on('meeting_minutes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_minute_attachments');
    }
};
