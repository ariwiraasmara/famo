<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *   id int(255) not null primary key auto_integer,
     */
    public function up(): void
    {
        Schema::create('user_file', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->foreignId('id_user');
            $table->text('foto')->nullable()->default(null);
            $table->enum('filetype', ['pdf', 'image']);
            $table->text('ket')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_file');
    }
};
