<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 150)->unique();
			$table->unsignedInteger('initial_state_id');
			$table->foreign('initial_state_id')->references('id')->on('business_record_state');
			$table->unsignedInteger('final_state_id');
			$table->foreign('final_state_id')->references('id')->on('business_record_state');
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
        Schema::dropIfExists('workflows');
    }
}
