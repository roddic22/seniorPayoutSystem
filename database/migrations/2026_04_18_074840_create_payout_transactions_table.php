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
    Schema::create('payout_transactions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cycle_id');
        $table->unsignedBigInteger('senior_id');
        $table->unsignedBigInteger('schedule_id')->nullable();
        $table->unsignedBigInteger('counter_id')->nullable();
        $table->unsignedBigInteger('processed_by')->nullable();
        $table->decimal('amount', 10, 2)->default(0.00);
        $table->enum('claim_status', ['claimed', 'unclaimed', 'cancelled'])->default('unclaimed');
        $table->timestamp('claimed_at')->nullable();
        $table->text('remarks')->nullable();
        $table->foreign('cycle_id')->references('id')->on('payout_cycles')->cascadeOnDelete();
        $table->foreign('senior_id')->references('id')->on('seniors')->cascadeOnDelete();
        $table->foreign('schedule_id')->references('id')->on('payout_schedules')->nullOnDelete();
        $table->foreign('counter_id')->references('id')->on('counters')->nullOnDelete();
        $table->foreign('processed_by')->references('id')->on('users')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_transactions');
    }
};
