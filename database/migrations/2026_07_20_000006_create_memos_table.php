<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('body');
            $table->uuid('created_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_by_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
