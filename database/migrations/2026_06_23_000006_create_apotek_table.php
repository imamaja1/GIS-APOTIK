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
        Schema::create('tb_apotek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kecamatan_id');
            $table->string('nama_apotek', 150);
            $table->string('jalan_apotek', 150)->comment('Nama jalan langsung diketik teks manual');
            $table->text('alamat_lengkap');
            $table->string('no_telp', 20)->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('tb_kecamatan')
                ->onDelete('cascade');

            // Index untuk performa query
            $table->index('kecamatan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_apotek');
    }
};
