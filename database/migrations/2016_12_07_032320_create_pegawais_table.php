<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pegawai', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nama', 50);
			$table->string('username', 50)->unique();
			$table->string('password');
			$table->enum('status', ['ADMIN', 'PEGAWAI', 'MANAGER']);
			$table->rememberToken()->nullable();
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
		Schema::drop('pegawai');
	}

}
