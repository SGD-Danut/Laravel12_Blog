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
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->default('defaultUserPhoto.png')->after('remember_token');
            $table->string('phone')->nullable()->after('remember_token');
            $table->string('address')->nullable()->after('remember_token');
            $table->string('role')->default('editor')->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('role');
        });
    }
};
