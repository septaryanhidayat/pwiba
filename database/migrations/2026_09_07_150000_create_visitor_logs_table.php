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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->string('url', 255);
            $table->string('route_name', 100)->nullable();
            $table->string('method', 10)->default('GET');
            $table->string('referrer', 500)->nullable();
            $table->string('referrer_domain', 100)->nullable();
            $table->string('referrer_type', 50)->default('Direct');
            $table->text('user_agent')->nullable();
            $table->string('device_type', 20)->default('Desktop');
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index(['ip_address', 'created_at']);
            $table->index(['session_id', 'created_at']);
            $table->index(['url', 'created_at']);
            $table->index('referrer_domain');
            $table->index('device_type');
            $table->index('browser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
