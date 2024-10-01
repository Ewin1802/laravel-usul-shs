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
        Schema::create('proses_shs', function (Blueprint $table) {
            $table->id();
            $table->string('Kode')->nullable();
            $table->string('Uraian')->nullable();
            $table->string('Spek')->nullable();
            $table->string('Satuan')->nullable();
            $table->string('Harga')->nullable();
            $table->string('akun_belanja')->nullable();
            $table->string('rekening_1')->nullable();
            $table->string('rekening_2')->nullable();
            $table->string('rekening_3')->nullable();
            $table->string('rekening_4')->nullable();
            $table->string('rekening_5')->nullable();
            $table->string('rekening_6')->nullable();
            $table->string('rekening_7')->nullable();
            $table->string('rekening_8')->nullable();
            $table->string('rekening_9')->nullable();
            $table->string('rekening_10')->nullable();
            $table->string('Kelompok')->nullable();
            $table->string('nilai_tkdn')->nullable();
            $table->string('Document')->nullable();
            $table->string('ket')->nullable();
            $table->string('alasan')->nullable();
            $table->string('skpd')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('proses_shs');
    }
};
