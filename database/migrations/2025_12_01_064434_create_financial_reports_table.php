<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // uploaded file info
            $table->string('file_path');              // storage path
            $table->string('file_original_name');     // original filename
            $table->string('file_mime')->nullable();  // mime type
            $table->unsignedBigInteger('file_size')->nullable(); // in bytes

            $table->timestamp('published_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
