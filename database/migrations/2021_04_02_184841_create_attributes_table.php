<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            /* --- ID Атрибута --- */
            $table->increments('id');

                /* --- ID Пользователя --- */
            $table->integer('user_id');

                /* --- ID элемента --- */
            $table->integer('element_id');

                /* --- Название атрибута --- */ 
            $table->string('attribute_name');

                /* --- Описание атрибута --- */ 
            $table->string('attribute_description', 300)->nullable();

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
        Schema::dropIfExists('attributes');
    }
}
