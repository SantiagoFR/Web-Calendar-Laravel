<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {            
            $table->dropColumn('startEditable');
            $table->dropColumn('eventResizableFromStart');
            $table->dropColumn('eventDurationEditable');
            $table->dropColumn('resourceEditable');
            $table->text('rrule')->nullable()->after('editable');
            $table->dateTime('start')->nullable()->change();
            $table->dateTime('end')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {                     
            $table->string('startEditable');
            $table->string('eventResizableFromStart');
            $table->string('eventDurationEditable');
            $table->string('resourceEditable');
            $table->dropColumn('rrule');
        });
    }
}
