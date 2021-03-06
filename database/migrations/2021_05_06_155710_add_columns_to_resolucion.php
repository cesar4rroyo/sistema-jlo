<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resolucion', function (Blueprint $table) {
            $table->string('proyecto')->nullable();
            $table->string('nombrecomercial')->nullable();
            $table->string('uso')->nullable();
            $table->string('altura')->nullable();
            $table->string('responsableobra')->nullable();
            $table->string('funcionamiento')->nullable();
            $table->string('nroexpediente')->nullable();
            $table->string('nrocertificado')->nullable();
            $table->double('area' , 10 , 2)->nullable();
            $table->double('valor' , 10 , 2)->nullable();
            $table->string('viapublica')->default('No');
          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resolucion', function (Blueprint $table) {
            $table->dropColumn('proyecto');
            $table->dropColumn('nombrecomercial');
            $table->dropColumn('uso');
            $table->dropColumn('altura');
            $table->dropColumn('responsableobra');
            $table->dropColumn('nroexpediente');
            $table->dropColumn('nrocertificado');
            $table->dropColumn('funcionamiento');
            $table->dropColumn('valor');
            $table->dropColumn('area');
            $table->dropColumn('viapublica');
        });
    }
}
