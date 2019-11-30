<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('version_id')->nullable();
            $table->unsignedBigInteger('ticket_parent_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->integer('status');
            $table->integer('priority');
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('estimated_time');
            $table->integer('progress');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('set null');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');
            $table->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
