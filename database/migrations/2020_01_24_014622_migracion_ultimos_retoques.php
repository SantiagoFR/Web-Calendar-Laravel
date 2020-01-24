<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigracionUltimosRetoques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etiqueta_permiso', function (Blueprint $table) {
            $table->unsignedBigInteger('permiso_id')->change();
            $table->foreign('permiso_id')
                ->references('id')
                ->on('permisos');
            $table->unsignedBigInteger('etiqueta_id')->change();
            $table->foreign('etiqueta_id')
                ->references('id')
                ->on('etiquetas');
        });
        Schema::table('evento_user', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id')->change();
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos');
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
        Schema::table('permiso_user', function (Blueprint $table) {
            $table->unsignedBigInteger('permiso_id')->change();
            $table->foreign('permiso_id')
                ->references('id')
                ->on('permisos');
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('groupId');
            $table->dropColumn('allDay');
            $table->dropColumn('editable');
            $table->dropColumn('overlap');
            $table->unsignedBigInteger('creator_id')->change();
            $table->foreign('creator_id')
                ->references('id')
                ->on('users');
            $table->unsignedBigInteger('etiqueta_id')->change();
            $table->foreign('etiqueta_id')
                ->references('id')
                ->on('etiquetas');
        });
        Schema::table('peticions', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id')->change();
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
