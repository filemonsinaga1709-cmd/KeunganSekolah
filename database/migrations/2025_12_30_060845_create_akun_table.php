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
      Schema::create('akuns', function (Blueprint $table) { // Ubah jadi plural
            $table->id();
            $table->string('kode_akun', 20)->unique();
            $table->string('nama_akun');
            $table->enum('tipe_akun', [
                'aset',
                'kewajiban',
                'modal',
                'pendapatan',
                'beban'
            ]);
            $table->boolean('is_active')->default(true); // Tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
