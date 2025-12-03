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
        Schema::create('u_e_s', function (Blueprint $table) {
            $table->foreignUuid('participant_id')->constrained()->primary();
            $table->integer('fas1');
            $table->integer('fas2');
            $table->integer('fas3');
            $table->integer('pus1');
            $table->integer('pus2');
            $table->integer('pus3');
            $table->integer('aes1');
            $table->integer('aes2');
            $table->integer('aes3');
            $table->integer('rws1');
            $table->integer('rws2');
            $table->integer('rws3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_e_s');
    }
};
