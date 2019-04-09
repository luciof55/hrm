<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->increments('id');
			$table->string('anio', 50);
			$table->unsignedInteger('seller_id');
			$table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
			$table->unsignedInteger('account_id');
			$table->foreign('account_id')->references('id')->on('accounts');
			$table->unsignedInteger('category_id');
			$table->foreign('category_id')->references('id')->on('categories');
			$table->mediumText('zonas')->nullable($value = true);
			$table->mediumText('comentarios');
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
        Schema::dropIfExists('interviews');
    }
}
