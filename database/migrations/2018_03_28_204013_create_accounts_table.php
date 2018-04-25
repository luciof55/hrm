<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('name', 150)->unique();
			$table->string('industry', 150);
			$table->string('url', 150)->unique();
			$table->multiLineString('notes')->nullable($value = true);
			$table->softDeletes();
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
        Schema::dropIfExists('accounts');
    }
}
