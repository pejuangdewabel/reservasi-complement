<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('history_transactions', function (Blueprint $table) {
            $table->id();
            $table->json('kode');
            $table->json('unit');
            $table->integer('jumlah_tiket');
            $table->integer('jumlah_org_per_tiket');
            $table->date('tgl_mulai');
            $table->date('tgl_berlaku');
            $table->string('kendaran');
            $table->integer('jumlah_kendaraan_per_tiket');
            $table->bigInteger('user_create')->unsigned();

            $table->foreign('user_create')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('history_transactions');
    }
}
