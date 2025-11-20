<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->string('course_code', 50)->comment('講座コード');
            $table->unsignedBigInteger('course_type_id')->comment('講座分野');
            $table->unsignedBigInteger('level_id')->comment('講座種類');
            $table->unsignedBigInteger('organizer_id')->comment('実施主体ID');
            $table->string('course_name', 255)->comment('講座名');
            $table->string('venue', 255)->nullable()->comment('実施会場');
            $table->date('application_date')->nullable()->comment('申請日');
            $table->date('certification_date')->nullable()->comment('認定日');
            $table->string('certification_number', 100)->nullable()->comment('認定番号');
            $table->date('start_date')->nullable()->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            $table->integer('total_hours')->nullable()->comment('総授業時間');
            $table->integer('periods')->nullable()->comment('時限数');
            $table->time('start_time')->nullable()->comment('開始時間');
            $table->time('finish_time')->nullable()->comment('終了時間');
            $table->date('start_viewing')->nullable()->comment('閲覧期間開始');
            $table->date('finish_viewing')->nullable()->comment('閲覧期間終了');
            $table->string('plan_path', 255)->nullable()->comment('日別計画書のパス');
            $table->string('flier_path', 255)->nullable()->comment('フライヤーのパス');
            $table->integer('capacity')->nullable()->comment('定員数');
            $table->integer('entering')->nullable()->comment('入校数');
            $table->integer('completed')->nullable()->comment('修了数');
            $table->text('description')->nullable()->comment('概要・説明');
            $table->string('mail_address', 255)->nullable()->comment('日報送信宛先');
            $table->string('cc_address', 255)->nullable()->comment('日報送信CC');

            $table->integer('status')->default(0);
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー制約
            $table->foreign('course_type_id')->references('id')->on('course_types');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('organizer_id')->references('id')->on('organizers');

            $table->comment('講座マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
