<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id()->comment('主キーID');
            $table->string('name')->comment('資格名');
            $table->tinyInteger('level')->nullable()->comment('レベル（1=初級, 2=上級）');
            $table->text('description')->nullable()->comment('資格説明文');
            $table->string('url')->nullable()->comment('関連URL');

            // 表示フラグを統一
            $table->boolean('is_show')->default(1)->comment('表示フラグ 1=表示, 0=非表示');

            $table->softDeletes();
            $table->timestamps();
        });

        // もし過去に display_flag カラムが残っていた場合は、rename して統一する
        if (Schema::hasColumn('certifications', 'display_flag')) {
            Schema::table('certifications', function (Blueprint $table) {
                $table->renameColumn('display_flag', 'is_show');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
