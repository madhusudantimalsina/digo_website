<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // 1) Drop old numeric status column if it exists
            if (Schema::hasColumn('form_submissions', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            // 2) Recreate it as a string column
            $table->string('status', 20)->default('new')->after('extra_data');
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('form_submissions', 'status')) {
                $table->dropColumn('status');
            }

            // Optional: restore as tinyInteger if you ever roll back
            $table->tinyInteger('status')->default(0);
        });
    }
};
