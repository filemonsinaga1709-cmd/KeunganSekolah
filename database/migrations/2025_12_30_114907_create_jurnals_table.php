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
      Schema::create('jurnals', function (Blueprint $table) {
    $table->id();
    $table->string('no_jurnal')->unique(); // Tambahan untuk tracking
    $table->date('tanggal');
    $table->text('keterangan');
    $table->enum('jenis', ['umum', 'penyesuaian', 'penutup'])->default('umum'); // Tambahan
    $table->string('ref_tipe')->nullable(); // 'pembayaran', 'pemasukan', 'pengeluaran'
    $table->unsignedBigInteger('ref_id')->nullable(); // ID dari tabel rujukan
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Siapa yang buat
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
