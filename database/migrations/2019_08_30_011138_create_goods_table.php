<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("good_id");
            $table->string("good_name");
            $table->string("good_producer");
            $table->string("good_publisher");
            $table->integer("good_price");
            $table->string("picture_path");
            $table->bigInteger("good_category")->unsigned();
            $table->foreign("good_category")->references("id")->on("goods_categories");
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
        Schema::dropIfExists('goods');
    }
}
