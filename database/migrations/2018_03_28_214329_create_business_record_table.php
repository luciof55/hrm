<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_records', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 150)->unique();
			$table->unsignedInteger('account_id');
			$table->foreign('account_id')->references('id')->on('accounts');
			$table->unsignedInteger('state_id');
			$table->foreign('state_id')->references('id')->on('business_record_state');
			$table->unsignedInteger('leader_id')->nullable($value = true);
			$table->foreign('leader_id')->references('id')->on('users');
			$table->unsignedInteger('comercial_id');
			$table->foreign('comercial_id')->references('id')->on('users');
			$table->string('management_tool', 250)->nullable($value = true);
			$table->string('repository', 250)->nullable($value = true);
			$table->string('notes', 1024)->nullable($value = true);
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
        Schema::dropIfExists('business_records');
    }
}
