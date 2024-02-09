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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('cron', 255)->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->timestamp('next_run');
            $table->string('class_runner');
            $table->json('input_parameters');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('just_once')->default(true);
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
