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
    Schema::create('staff_assignments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('schedule_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('counter_id');
        $table->foreign('schedule_id')->references('id')->on('payout_schedules')->cascadeOnDelete();
        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('counter_id')->references('id')->on('counters')->cascadeOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_assignments');
    }
};
