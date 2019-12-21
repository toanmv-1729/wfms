<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnContentToTicketHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_histories', function (Blueprint $table) {
            $table->text('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_histories', function (Blueprint $table) {
            $table->json('content')->change();
        });
    }
}
