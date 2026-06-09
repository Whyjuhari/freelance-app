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
        Schema::create('ai_chat_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('conversation_id')->nullable()->index();
            $table->text('message');
            $table->text('response');
            $table->integer('tokens_used')->default(0);
            $table->string('model')->default('llama-3.1-70b-versatile');
            $table->timestamps();

            $table->index('user_id');
            $table->index('created_at');
            $table->index(['user_id', 'conversation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chat_history');
    }
};