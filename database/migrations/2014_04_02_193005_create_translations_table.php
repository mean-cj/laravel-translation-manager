<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('ltm_translations', function($collection)
        {
            $collection->increments('id');
            $collection->tinyInteger('status')->default(0);
            $collection->string('locale', 32);
            $collection->string('group', 128);
            $collection->string('key', 128);
            $collection->text('value')->nullable();
            $collection->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('ltm_translations');
	}

}
