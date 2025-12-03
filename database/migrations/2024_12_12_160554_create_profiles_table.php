<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignUuid('participant_id')->constrained()->primary();
            $table->integer('age');
            $table->text('main_expertise');
            $table->text('education');
            $table->text('gaming_experience');
            $table->text('cybersecurity');
            $table->text('steganography');
            $table->text('stego_explanation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
