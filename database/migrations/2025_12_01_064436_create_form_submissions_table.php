<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();

            // Link to forms table (contact, membership, etc.)
            $table->foreignId('form_id')
                  ->nullable()
                  ->constrained('forms')
                  ->nullOnDelete();

            $table->string('full_name');
            $table->string('email');
            $table->text('message')->nullable();

            // For future additional fields (phone, address, etc.)
            $table->json('extra_data')->nullable();

            // new / seen / processed
            $table->string('status')->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
