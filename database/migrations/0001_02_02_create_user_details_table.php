<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {

            $table->id()->comment('主キー');

            $table->unsignedBigInteger('user_id')->comment('ユーザーID');

            $table->date('birthday')->nullable()->comment('生年月日');
            $table->tinyInteger('gender')->nullable()->comment('性別');
            $table->string('phone1', 50)->nullable()->comment('電話番号1');
            $table->string('phone2', 50)->nullable()->comment('電話番号2');
            $table->string('postal_code', 10)->nullable()->comment('郵便番号');
            $table->string('address1', 255)->nullable()->comment('住所1');
            $table->string('address2', 255)->nullable()->comment('住所2');
            $table->string('emergency_contact', 50)->nullable()->comment('緊急連絡先');
            $table->string('avatar_path', 255)->nullable()->comment('写真パス');

            $table->unsignedBigInteger('theme_id')->default(1)->comment('テーマID');

            $table->unsignedBigInteger('fontsize')->default(1)->comment('文字サイズ');

            $table->tinyInteger('status')->nullable()->comment('ユーザー状態');
            $table->text('bio')->nullable()->comment('自己紹介');
            $table->text('note')->nullable()->comment('メモ');
            $table->string('memo', 255)->nullable()->comment('備考');

            $table->date('joining_date')->nullable()->comment('入社日／入所日');
            $table->date('leaving_date')->nullable()->comment('退所日／退職日');
            $table->string('leaving_reason', 512)->nullable()->comment('退校理由');

            // Laravel 自動管理
            $table->timestamps();      // created_at / updated_at
            $table->softDeletes();     // deleted_at

            // 追加の管理項目
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            $table->comment('ユーザー詳細');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
