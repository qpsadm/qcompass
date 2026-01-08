<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // 新しいカラムを追加（nullableで一旦追加）
            $table->unsignedBigInteger('category_id')->nullable()->after('description')->comment('紐づくカテゴリID');
            $table->integer('level')->nullable()->after('category_id')->comment('レベル');
        });

        // データを移行
        DB::table('quizzes')->update([
            'category_id' => DB::raw('course_id'),
            'level' => DB::raw('agenda_id')
        ]);

        Schema::table('quizzes', function (Blueprint $table) {
            // 古いカラムを削除
            $table->dropColumn(['course_id', 'agenda_id']);
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // 古いカラムを戻す
            $table->unsignedBigInteger('course_id')->nullable()->after('description')->comment('紐づくコースID');
            $table->unsignedBigInteger('agenda_id')->nullable()->after('course_id')->comment('紐づくアジェンダID');
        });

        // データを戻す
        DB::table('quizzes')->update([
            'course_id' => DB::raw('category_id'),
            'agenda_id' => DB::raw('level')
        ]);

        Schema::table('quizzes', function (Blueprint $table) {
            // 新しいカラムを削除
            $table->dropColumn(['category_id', 'level']);
        });
    }
};
