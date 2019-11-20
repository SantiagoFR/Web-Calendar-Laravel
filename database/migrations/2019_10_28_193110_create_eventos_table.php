<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->bigInteger('groupId')->nullable();
            $table->boolean('allDay')->default(0);
            $table->string('url')->nullable();
            $table->boolean('editable')->nullable();
            $table->boolean('startEditable')->nullable();
            $table->boolean('eventResizableFromStart')->nullable();
            $table->boolean('eventDurationEditable')->nullable();
            $table->boolean('resourceEditable')->nullable();
            $table->boolean('overlap')->nullable();
            $table->bigInteger('etiqueta_id')->nullable();
            $table->bigInteger('creator_id')->nullable();
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
        Schema::dropIfExists('eventos');
    }
}
