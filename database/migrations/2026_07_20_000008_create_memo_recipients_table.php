<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memo_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('memo_id');
            $table->enum('recipient_type', ['all', 'committee', 'member']);
            $table->uuid('recipient_id')->nullable();
            $table->timestamps();

            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');
            $table->index(['recipient_type', 'recipient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memo_recipients');
    }
};
