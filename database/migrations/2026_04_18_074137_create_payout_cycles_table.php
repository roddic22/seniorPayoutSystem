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
    Schema::create('payout_cycles', function (Blueprint $table) {
        $table->id();
        $table->string('cycle_name');
        $table->date('period_start');
        $table->date('period_end');
        $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
        $table->unsignedBigInteger('created_by')->nullable();
        $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_cycles');
    }
};
