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
    Schema::create('payout_schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cycle_id');
        $table->unsignedBigInteger('barangay_id')->nullable();
        $table->date('scheduled_date');
        $table->time('time_start')->nullable();
        $table->time('time_end')->nullable();
        $table->string('venue')->nullable();
        $table->foreign('cycle_id')->references('id')->on('payout_cycles')->cascadeOnDelete();
        $table->foreign('barangay_id')->references('id')->on('barangays')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_schedules');
    }
};
