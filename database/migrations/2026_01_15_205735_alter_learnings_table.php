<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learnings', function (Blueprint $table) {

            // type：tinyInteger → integer（制作品=4 を想定）
            $table->integer('type')
                ->comment('種別（1:参考書籍、2:参考サイト、3:IT資格、4:制作品）')
                ->change();

            // tag_id：unsignedBigInteger → integer（コード管理に合わせる）
            $table->integer('tag_id')
                ->nullable()
                ->comment('タグID（1:WEB制作、2:WEBデザイン、3:プログラミング、4:OA、5:その他）')
                ->change();

            // level：default 1 を追加
            $table->integer('level')
                ->default(1)
                ->comment('レベル（1:初級、2:中級、3:上級）')
                ->change();

            // 訓練科名（なければ追加）
            if (!Schema::hasColumn('learnings', 'course_name')) {
                $table->string('course_name', 100)
                    ->nullable()
                    ->comment('著者名、講座名＋チーム名＋人数')
                    ->after('level');
            }

            // 制作期間（なければ追加）
            if (!Schema::hasColumn('learnings', 'priod')) {
                $table->string('priod', 100)
                    ->nullable()
                    ->comment('制作品紹介用')
                    ->after('course_name');
            }

            // is_show：default true を保証
            $table->boolean('is_show')
                ->default(true)
                ->comment('表示フラグ')
                ->change();

            // 作成者・更新者・削除者（なければ追加）
            if (!Schema::hasColumn('learnings', 'created_user_name')) {
                $table->string('created_user_name', 50)
                    ->nullable()
                    ->comment('作成者名')
                    ->after('deleted_at');
            }

            if (!Schema::hasColumn('learnings', 'updated_user_name')) {
                $table->string('updated_user_name', 50)
                    ->nullable()
                    ->comment('更新者名')
                    ->after('created_user_name');
            }

            if (!Schema::hasColumn('learnings', 'deleted_user_name')) {
                $table->string('deleted_user_name', 50)
                    ->nullable()
                    ->comment('削除者名')
                    ->after('updated_user_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('learnings', function (Blueprint $table) {

            // 追加したカラムのみ戻す（安全側）
            if (Schema::hasColumn('learnings', 'course_name')) {
                $table->dropColumn('course_name');
            }

            if (Schema::hasColumn('learnings', 'priod')) {
                $table->dropColumn('priod');
            }

            if (Schema::hasColumn('learnings', 'created_user_name')) {
                $table->dropColumn('created_user_name');
            }

            if (Schema::hasColumn('learnings', 'updated_user_name')) {
                $table->dropColumn('updated_user_name');
            }

            if (Schema::hasColumn('learnings', 'deleted_user_name')) {
                $table->dropColumn('deleted_user_name');
            }
        });
    }
};
