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
    // Fix seniors.barangay_id — currently has no FK constraint
    Schema::table('seniors', function (Blueprint $table) {
        $table->foreign('barangay_id')
              ->references('id')->on('barangays')
              ->onDelete('set null')
              ->onUpdate('cascade'); // ON UPDATE CASCADE — Module 2
    });

    // Add ON UPDATE CASCADE to payout_schedules
    Schema::table('payout_schedules', function (Blueprint $table) {
        $table->dropForeign(['cycle_id']);
        $table->dropForeign(['barangay_id']);

        $table->foreign('cycle_id')
              ->references('id')->on('payout_cycles')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('barangay_id')
              ->references('id')->on('barangays')
              ->onDelete('set null')
              ->onUpdate('cascade');
    });

    // Add ON UPDATE CASCADE to payout_transactions
    Schema::table('payout_transactions', function (Blueprint $table) {
        $table->dropForeign(['cycle_id']);
        $table->dropForeign(['senior_id']);

        $table->foreign('cycle_id')
              ->references('id')->on('payout_cycles')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('senior_id')
              ->references('id')->on('seniors')
              ->onDelete('cascade')
              ->onUpdate('cascade');
    });
}

public function down(): void
{
    Schema::table('seniors', function (Blueprint $table) {
        $table->dropForeign(['barangay_id']);
    });

    Schema::table('payout_schedules', function (Blueprint $table) {
        $table->dropForeign(['cycle_id']);
        $table->dropForeign(['barangay_id']);
    });

    Schema::table('payout_transactions', function (Blueprint $table) {
        $table->dropForeign(['cycle_id']);
        $table->dropForeign(['senior_id']);
    });
}
};
