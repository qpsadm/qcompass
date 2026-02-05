<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->tinyInteger('avatar_type')
                ->default(1)
                ->after('avatar_path')
                ->comment('アバター種別');
        });
    }

    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('avatar_type');
        });
    }
};
