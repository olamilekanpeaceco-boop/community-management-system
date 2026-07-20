<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('member_id_number')->unique();
            $table->date('date_joined');
            $table->enum('membership_status', ['active', 'inactive', 'suspended', 'resigned'])->default('active');
            $table->text('bio')->nullable();
            $table->string('occupation')->nullable();
            $table->string('department')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('profile_picture_url')->nullable();
            $table->json('skills')->nullable();
            $table->json('interests')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by_id')->references('id')->on('users')->onDelete('set null');
            $table->index('membership_status');
            $table->index('date_joined');
            $table->unique('member_id_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
