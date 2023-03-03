<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisTiketToHistoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('history_transactions', function (Blueprint $table) {
            $table->string('kode_jenis_tiket')->after('id')->nullable();
            $table->foreign('kode_jenis_tiket')
                ->references('kode')
                ->on('jenis_tikets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_transactions', function (Blueprint $table) {
            $table->dropColumn('kode_jenis_tiket');
        });
    }
}
