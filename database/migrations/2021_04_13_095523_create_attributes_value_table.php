<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_value', function (Blueprint $table) {
            $table->increments('id');

                /* --- ID Пользователя --- */
            $table->integer('user_id');

                /* --- ID Категории --- */
            $table->integer('attribute_id');

                /* --- Время начало --- */
            $table->time('attribute_time_first')->nullable();

                /* --- Время окончание--- */
            $table->time('attribute_time_second')->nullable();

                /* --- Число --- */
            $table->integer('attribute_int')->nullable();

                /* --- Дробное число .2 --- */
            $table->float('attribute_float', 8, 2)->nullable();

                /* --- Дробное число .15 --- */
            $table->double('attribute_double', 15, 8)->nullable();

                /* --- Текст 300 + --- */
            $table->longText('attribute_text')->nullable();

                /* --- Текст 300 --- */
            $table->string('attribute_varchar', 300)->nullable();

                /* --- Изображение --- */
            $table->longText('attribute_img')->nullable();

                /* --- Истина/Ложь --- */
            $table->boolean('attribute_bool')->nullable();

                /* --- IP Адрес --- */
            $table->ipAddress('attribute_IP')->nullable();

                /* --- JSON --- */
            $table->json('attribute_json')->nullable();

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
        Schema::dropIfExists('attributes_value');
    }
}
