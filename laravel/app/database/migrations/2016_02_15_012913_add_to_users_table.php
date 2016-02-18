<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->string('note')->nullable();
			$table->string('todo')->nullable();
			$table->string('image')->nullable();
			/* websites ar linked to here via the sites table */
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function ($table) {
			$table->dropColumn('note');
			$table->dropColumn('todo');
			$table->dropColumn('image');
		});
	}

}
