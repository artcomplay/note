<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripts', function (Blueprint $table) {

        $table->increments('id');

            /* --- ID Пользователя --- */
        $table->integer('user_id');

            /* --- ID элемента --- */
        $table->integer('element_id');

            /* --- Название атрибута --- */ 
        $table->string('script_name');

            /* --- Описание атрибута --- */ 
        $table->longText('attribute_text')->nullable();

            /* --- Дата создания --- */
        $table->dateTime('created_at');

            /* --- Дата обновления --- */
        $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scripts');
    }
}
