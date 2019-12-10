<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('permiso_id');
            $table->bigInteger('user_id');
            $table->index('permiso_id');
            $table->index('user_id');            
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
        Schema::dropIfExists('permiso_user');
    }
}
