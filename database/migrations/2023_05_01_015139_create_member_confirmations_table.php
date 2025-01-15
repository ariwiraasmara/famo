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
        Schema::create('member_confirmation', function (Blueprint $table) {
            $table->string('idc')->primary();
            $table->datetime('date_ask')->nullable()->default(null);
            $table->datetime('date_confirm')->nullable()->default(null);
            $table->foreignId('id_requestor');
            $table->foreignId('id_recipient');
            $table->enum('type', ['invite', 'join'])->nullable()->default(null);
            $table->integer('is_rejected')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_confirmation');
    }
};
