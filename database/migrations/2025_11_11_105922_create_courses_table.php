<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code', 50);
            $table->integer('course_type_ID');
            $table->integer('Level_id')->nullable();
            $table->string('organizer_id')->nullable();
            $table->string('course_name', 255);
            $table->string('venue', 255)->nullable();
            $table->date('application_date')->nullable();
            $table->date('certification_date')->nullable();
            $table->string('certification_number', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_hours')->nullable();
            $table->integer('periods')->nullable();
            $table->time('start_time')->nullable();
            $table->time('finish_time')->nullable();
            $table->date('start_viewing')->nullable();
            $table->date('finish_viewing')->nullable();
            $table->string('plan_path', 255)->nullable();
            $table->string('flier_path', 255)->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('entering')->nullable();
            $table->integer('completed')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0: draft, 1: published, 2: archived');


            // 作成・更新・削除日時
            $table->timestamps();       // created_at, updated_at
            $table->softDeletes();      // deleted_at

            // 作成者・更新者・削除者
            $table->unsignedBigInteger('created_user_id')->nullable();
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('deleted_user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
