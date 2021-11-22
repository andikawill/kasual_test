<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpreadsheetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spreadsheets', function (Blueprint $table) {
            $table->id('id');
            $table->First('[first_name,');
            $table->Last('[last_name,');
            $table->Gender]('[gender,');
            $table->Email]('[email,');
            $table->IP('[ip_address,');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('spreadsheets');
    }
}
