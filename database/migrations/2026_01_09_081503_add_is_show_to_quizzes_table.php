<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // 公開フラグを追加（デフォルト1=公開）
            $table->boolean('is_show')->default(1)->after('status')->comment('公開フラグ 1=公開 0=非公開');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('is_show');
        });
    }
};
