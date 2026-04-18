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
    Schema::create('document_requirements', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cycle_id');
        $table->string('document_name');
        $table->text('description')->nullable();
        $table->boolean('is_mandatory')->default(true);
        $table->foreign('cycle_id')->references('id')->on('payout_cycles')->cascadeOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requirements');
    }
};
