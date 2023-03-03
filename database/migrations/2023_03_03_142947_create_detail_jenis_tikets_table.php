<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailJenisTiketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jenis_tikets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('unit_id')->unsigned();
            $table->string('kode_jenis_tiket');
            $table->string('kode_jenis');


            $table->foreign('unit_id')
                ->references('id')
                ->on('unit')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('kode_jenis_tiket')
                ->references('kode')
                ->on('jenis_tikets')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('detail_jenis_tikets');
    }
}
