<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // Add only if they do not already exist
            if (!Schema::hasColumn('form_submissions', 'full_name')) {
                $table->string('full_name')->after('form_id');
            }

            if (!Schema::hasColumn('form_submissions', 'email')) {
                $table->string('email')->after('full_name');
            }

            if (!Schema::hasColumn('form_submissions', 'message')) {
                $table->text('message')->nullable()->after('email');
            }

            if (!Schema::hasColumn('form_submissions', 'extra_data')) {
                $table->json('extra_data')->nullable()->after('message');
            }

            if (!Schema::hasColumn('form_submissions', 'status')) {
                $table->string('status')->default('new')->after('extra_data');
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('form_submissions', 'full_name')) {
                $table->dropColumn('full_name');
            }
            if (Schema::hasColumn('form_submissions', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('form_submissions', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('form_submissions', 'extra_data')) {
                $table->dropColumn('extra_data');
            }
            if (Schema::hasColumn('form_submissions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
