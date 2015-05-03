<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateServiceRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('request_body');
            $table->text('response_body');
			$table->text('request_headers');
            $table->text('response_headers');
			$table->text('cookies');
			$table->string('url');
            $table->string('method');
			$table->integer('status_code');
            $table->string('response_type');
            $table->float('time_elapsed',16,8);
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
		Schema::drop('service_requests');
	}

}
