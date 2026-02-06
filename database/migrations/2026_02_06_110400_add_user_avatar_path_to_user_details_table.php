<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('user_details', 'user_avatar_path')) {
            Schema::table('user_details', function (Blueprint $table) {
                $table->string('user_avatar_path', 255)
                    ->nullable()
                    ->comment('ユーザーアバターパス');
            });
        }
    }
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('user_avatar_path');
        });
    }
};
