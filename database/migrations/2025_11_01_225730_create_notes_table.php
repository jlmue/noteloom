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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->comment('User who owns the note');
            $table->string('title')
                ->comment('Note title');
            $table->text('content')
                ->comment('Note content');
            $table->boolean('is_important')
                ->nullable()
                ->default(false)
                ->comment('Whether note is marked as important');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
