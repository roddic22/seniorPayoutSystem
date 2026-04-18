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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cycle_id');
        $table->unsignedBigInteger('generated_by')->nullable();
        $table->string('report_type');
        $table->string('file_path')->nullable();
        $table->timestamp('generated_at')->nullable();
        $table->foreign('cycle_id')->references('id')->on('payout_cycles')->cascadeOnDelete();
        $table->foreign('generated_by')->references('id')->on('users')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
