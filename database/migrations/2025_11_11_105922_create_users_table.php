<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('furigana')->nullable();
            $table->string('roman_name')->nullable();
            $table->string('password');
            $table->integer('role_id')->default(0);
            $table->integer('courses_id')->default(0);
            $table->string('remember_token', 100)->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('deleted_user_id')->nullable();

            // Laravel 標準のタイムスタンプ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
