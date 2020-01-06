<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtiquetaPermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiqueta_permiso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('permiso_id');
            $table->bigInteger('etiqueta_id');
            $table->index('permiso_id');
            $table->index('etiqueta_id');   
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
        Schema::dropIfExists('etiqueta_permiso');
    }
}
