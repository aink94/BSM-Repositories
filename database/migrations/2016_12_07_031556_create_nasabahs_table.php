<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNasabahsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nasabah', function(Blueprint $table) {
            $table->increments('id');
			$table->string('uid', 10);
			$table->string('nis', 10);
			$table->string('nama', 50);
			$table->enum('status_kartu', ['GOLD', 'SILVER']);
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nasabah');
	}

}
