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
       Schema::create('jurnal_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('jurnal_id')->constrained('jurnals')->cascadeOnDelete();
    $table->foreignId('akun_id')->constrained('akuns')->cascadeOnDelete();
    $table->decimal('debit', 15, 2)->default(0);
    $table->decimal('kredit', 15, 2)->default(0);
    $table->timestamps();
    
    // Tambahan index untuk performa
    $table->index(['jurnal_id', 'akun_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_details');
    }
};
