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
    Schema::create('seniors', function (Blueprint $table) {
        $table->id();
        $table->string('osca_id')->unique();
        $table->string('name');
        $table->string('address');
        $table->integer('age');
        $table->date('birthdate')->nullable();
        $table->enum('sex', ['male', 'female'])->nullable();
        $table->string('contact_number')->nullable();
        $table->foreignId('barangay_id')->nullable()->constrained('barangays')->nullOnDelete();
        $table->string('status')->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seniors');
    }
};

?>