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
    Schema::create('document_submissions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transaction_id');
        $table->unsignedBigInteger('requirement_id');
        $table->boolean('is_submitted')->default(false);
        $table->string('notes')->nullable();
        $table->foreign('transaction_id')->references('id')->on('payout_transactions')->cascadeOnDelete();
        $table->foreign('requirement_id')->references('id')->on('document_requirements')->cascadeOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_submissions');
    }
};
