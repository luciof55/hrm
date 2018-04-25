<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_roles', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('profile_id');
			$table->foreign('profile_id')->references('id')->on('profiles');
			$table->unsignedInteger('role_id');
			$table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('profiles_roles');
    }
}
