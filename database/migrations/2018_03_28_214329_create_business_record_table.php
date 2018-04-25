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
        Schema::create('business_record', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('account_id');
			$table->foreign('account_id')->references('id')->on('accounts');
			$table->unsignedInteger('state_id');
			$table->foreign('state_id')->references('id')->on('business_record_state');
			$table->unsignedInteger('leader_id');
			$table->foreign('leader_id')->references('id')->on('users');
			$table->unsignedInteger('comercial_id');
			$table->foreign('comercial_id')->references('id')->on('users');
			$table->string('management_tool')->nullable($value = true);
			$table->string('repository')->nullable($value = true);
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
        Schema::dropIfExists('business_record');
    }
}
