<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('purpose')->nullable();
            $table->unsignedBigInteger('chair_id');
            $table->unsignedBigInteger('vice_chair_id')->nullable();
            $table->unsignedBigInteger('secretary_id')->nullable();
            $table->unsignedBigInteger('treasurer_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->date('founded_date')->nullable();
            $table->string('meeting_frequency')->nullable();
            $table->tinyInteger('meeting_day_of_week')->nullable();
            $table->time('meeting_time')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('budget_currency', 3)->default('USD');
            $table->string('logo_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('max_members')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('chair_id')->references('id')->on('members')->onDelete('restrict');
            $table->foreign('vice_chair_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('secretary_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('treasurer_id')->references('id')->on('members')->onDelete('set null');
            $table->index('status');
            $table->index('chair_id');
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
