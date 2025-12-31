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
      Schema::create('pemasukans', function (Blueprint $table) {
    $table->id();
    $table->string('no_transaksi')->unique(); // Tambahan
    $table->date('tanggal');
    $table->string('kategori')->nullable(); // sumber pemasukan
    $table->text('keterangan');
    $table->decimal('jumlah', 15, 2);
    $table->foreignId('akun_id')->nullable()->constrained('akuns')->nullOnDelete(); // Link ke COA
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
