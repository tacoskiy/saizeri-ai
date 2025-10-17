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
        Schema::create('talk_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('table_id')->index()->constrained('tables')->cascadeOnDelete();
            $table->ipAddress('ip_address');
            $table->string('user_agent');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_sessions');
    }
};
