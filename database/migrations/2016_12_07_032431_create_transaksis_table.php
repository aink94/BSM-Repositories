<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaksi', function(Blueprint $table) {
            $table->increments('id');
			$table->dateTime('tanggal');
			$table->integer('saldo');
			$table->integer('jumlah');
			$table->string('no_referensi', 50)->nullable();
			$table->unsignedInteger('pegawai_id')->nullable();
			$table->unsignedInteger('jenis_transaksi_id');
			$table->unsignedInteger('nasabah_id');
			$table->unsignedInteger('koperasi_id')->nullable();
            //$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaksi');
	}

}
