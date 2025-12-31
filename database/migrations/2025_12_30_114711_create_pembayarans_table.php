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
       Schema::create('pembayarans', function (Blueprint $table) {
    $table->id();
    $table->string('no_transaksi')->unique(); // Tambahan untuk tracking
    $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete(); // Sesuaikan
    $table->foreignId('jenis_pembayaran_id')->constrained('jenis_pembayarans')->cascadeOnDelete();
    $table->date('tanggal');
    $table->decimal('jumlah', 15, 2);
    $table->enum('metode_pembayaran', ['tunai', 'transfer', 'va'])->default('tunai'); // Tambahan
    $table->text('keterangan')->nullable(); // Tambahan
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
