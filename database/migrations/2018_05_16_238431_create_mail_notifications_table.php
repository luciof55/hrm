<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_notifications', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('entity_id');
			$table->foreign('entity_id')->references('id')->on('entities');
			$table->unsignedInteger('template_id');
			$table->foreign('template_id')->references('id')->on('templates');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_notifications');
    }
}
