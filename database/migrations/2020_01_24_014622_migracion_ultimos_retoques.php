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
                ->on('permisos')->onDelete('cascade');;
            $table->unsignedBigInteger('etiqueta_id')->change();
            $table->foreign('etiqueta_id')
                ->references('id')
                ->on('etiquetas')->onDelete('cascade');;
        });
        Schema::table('evento_user', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id')->change();
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
        });
        Schema::table('permiso_user', function (Blueprint $table) {
            $table->unsignedBigInteger('permiso_id')->change();
            $table->foreign('permiso_id')
                ->references('id')
                ->on('permisos')->onDelete('cascade');;
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');;
        });
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('groupId');
            $table->dropColumn('allDay');
            $table->dropColumn('editable');
            $table->dropColumn('overlap');
            $table->unsignedBigInteger('creator_id')->change();
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('etiqueta_id')->change();
            $table->foreign('etiqueta_id')
                ->references('id')
                ->on('etiquetas')->onDelete('cascade');
        });
        Schema::table('peticions', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id')->change();
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etiqueta_permiso', function (Blueprint $table) {
            $table->dropForeign('etiqueta_permiso_etiqueta_id_foreign');
            $table->dropForeign('etiqueta_permiso_permiso_id_foreign');
        });
        Schema::table('evento_user', function (Blueprint $table) {
            $table->dropForeign('evento_user_user_id_foreign');
            $table->dropForeign('evento_user_evento_id_foreign');
        });
        Schema::table('permiso_user', function (Blueprint $table) {
            $table->dropForeign('permiso_user_user_id_foreign');
            $table->dropForeign('permiso_user_permiso_id_foreign');
        });
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('groupId');
            $table->string('allDay');
            $table->string('editable');
            $table->string('overlap');
            $table->dropForeign('eventos_creator_id_foreign');
            $table->dropForeign('eventos_etiqueta_id_foreign');
        });
        Schema::table('peticions', function (Blueprint $table) {
            $table->dropForeign('peticions_evento_id_foreign');
        });
    }
}
