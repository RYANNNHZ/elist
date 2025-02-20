<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('title');
            $table->enum('pin',['not_pinned','pinned'])->default('not_pinned');
            $table->timestamp('expired')->nullable(); // Fix di sini
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->timestamps(); // Ini untuk created_at & updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};
