<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Number of active members at the time the expense was recorded.
            // Used to compute each member's fair share.
            $table->unsignedTinyInteger('member_count')->default(1)->after('spent_at');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('member_count');
        });
    }
};
