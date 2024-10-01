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
        Schema::create('usulan_sbus', function (Blueprint $table) {
            $table->id();
            $table->string('Kode');
            $table->string('Uraian');
            $table->string('Spek');
            $table->string('Satuan');
            $table->string('Harga');
            $table->string('akun_belanja');
            $table->string('rekening_1');
            $table->string('rekening_2')->nullable();
            $table->string('rekening_3')->nullable();
            $table->string('rekening_4')->nullable();
            $table->string('rekening_5')->nullable();
            $table->string('rekening_6')->nullable();
            $table->string('rekening_7')->nullable();
            $table->string('rekening_8')->nullable();
            $table->string('rekening_9')->nullable();
            $table->string('rekening_10')->nullable();
            $table->string('Kelompok')->default(4);
            $table->string('nilai_tkdn');
            $table->string('Document');
            $table->string('ket')->default('Proses Usul');
            $table->string('alasan')->nullable();
            $table->string('skpd');
            $table->string('user');
            $table->string('admin')->nullable();
            $table->string('disetujui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_sbus');
    }
};
