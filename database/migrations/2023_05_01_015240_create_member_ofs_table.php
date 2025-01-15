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
        Schema::create('member_of', function (Blueprint $table) {
            $table->string('mid')->primary();
            $table->foreignId('id_user');
            $table->foreignId('id_membership');
            $table->datetime('date_join')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_of');
    }
};
