<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('birthday')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone1', 50)->nullable();
            $table->string('phone2', 50)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('emergency_contact', 50)->nullable();
            $table->string('avatar_path', 255)->nullable();
            $table->enum('theme_color', ['red', 'blue', 'green', 'yellow'])->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->boolean('is_show')->default(true);
            $table->bigInteger('divisions_id')->nullable();
            $table->text('bio')->nullable();
            $table->text('memo1')->nullable();
            $table->text('memo2')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();
            $table->text('leaving_reason')->nullable();

            $table->timestamps();  // created_at / updated_at
            $table->softDeletes(); // deleted_at
            $table->unsignedBigInteger('created_user_id')->nullable();
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('deleted_user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};