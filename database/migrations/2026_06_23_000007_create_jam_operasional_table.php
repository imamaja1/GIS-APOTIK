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
        Schema::create('tb_jam_operasional', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apotek_id');
            $table->string('hari', 15)->comment('Senin / Selasa / Rabu / Kamis / Jumat / Sabtu / Minggu');
            $table->string('status_buka', 10)->comment('Buka / Tutup');
            $table->time('jam_buka')->nullable()->comment('Kosong jika status Tutup');
            $table->time('jam_tutup')->nullable()->comment('Kosong jika status Tutup');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('apotek_id')
                ->references('id')
                ->on('tb_apotek')
                ->onDelete('cascade');

            // Index untuk performa query
            $table->index('apotek_id');
            $table->index(['apotek_id', 'hari']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_jam_operasional');
    }
};
