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
        Schema::create('transitions', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 150)->unique();
			$table->unsignedInteger('workflow_id');
			$table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
			$table->unsignedInteger('from_state_id');
			$table->foreign('from_state_id')->references('id')->on('business_record_state');
			$table->unsignedInteger('to_state_id');
			$table->foreign('to_state_id')->references('id')->on('business_record_state');
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
        Schema::dropIfExists('transitions');
    }
}
