<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();

            // Basic fields
            $table->string('title');

            // Optional notice body (text content)
            $table->text('body')->nullable();

            // Attachment (any file: pdf, image, doc, etc.)
            $table->string('attachment_path')->nullable();          // storage path
            $table->string('attachment_original_name')->nullable(); // original file name
            $table->string('attachment_mime')->nullable();          // mime type (pdf, image/jpeg, etc.)

            // Flags
            $table->boolean('is_urgent')->default(false);
            $table->date('expires_at')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
