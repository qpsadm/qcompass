<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->string('file_path2', 255)->nullable()->comment('PDFファイル保存パス②')->after('file_path');
            $table->string('file_path3', 255)->nullable()->comment('PDFファイル保存パス③')->after('file_path2');
            $table->string('file_path4', 255)->nullable()->comment('PDFファイル保存パス④')->after('file_path3');
            $table->string('file_path5', 255)->nullable()->comment('PDFファイル保存パス⑤')->after('file_path4');
        });
    }

    public function down(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropColumn([
                'file_path2',
                'file_path3',
                'file_path4',
                'file_path5',
            ]);
        });
    }
};
