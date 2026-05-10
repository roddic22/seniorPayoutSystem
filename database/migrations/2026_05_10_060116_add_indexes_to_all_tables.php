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
    // seniors — frequently searched by status and barangay
    Schema::table('seniors', function (Blueprint $table) {
        $table->index('status');
        $table->index('barangay_id');
    });

    // payout_transactions — most queried table
    Schema::table('payout_transactions', function (Blueprint $table) {
        $table->index('claim_status');
        $table->index('cycle_id');
        $table->index('senior_id');
    });

    // payout_schedules — queried by date and cycle
    Schema::table('payout_schedules', function (Blueprint $table) {
        $table->index('scheduled_date');
        $table->index('cycle_id');
    });

    // document_requirements — queried by cycle
    Schema::table('document_requirements', function (Blueprint $table) {
        $table->index('cycle_id');
    });
}

public function down(): void
{
    Schema::table('seniors', function (Blueprint $table) {
        $table->dropIndex(['status']);
        $table->dropIndex(['barangay_id']);
    });

    Schema::table('payout_transactions', function (Blueprint $table) {
        $table->dropIndex(['claim_status']);
        $table->dropIndex(['cycle_id']);
        $table->dropIndex(['senior_id']);
    });

    Schema::table('payout_schedules', function (Blueprint $table) {
        $table->dropIndex(['scheduled_date']);
        $table->dropIndex(['cycle_id']);
    });

    Schema::table('document_requirements', function (Blueprint $table) {
        $table->dropIndex(['cycle_id']);
    });
}
};
