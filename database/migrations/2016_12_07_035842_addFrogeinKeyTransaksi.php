<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrogeinKeyTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('jenis_transaksi_id')->references('id')->on('jenis_transaksi');
            $table->foreign('nasabah_id')->references('id')->on('nasabah');
            $table->foreign('koperasi_id')->references('id')->on('koperasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign('transaksi_pegawai_id_foreign');
            $table->dropForeign('transaksi_jenis_transaksi_id_foreign');
            $table->dropForeign('transaksi_nasabah_id_foreign');
            $table->dropForeign('transaksi_koperasi_id_foreign');
        });
    }
}
