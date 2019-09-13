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
            $table->unsignedBigInteger("good_publisher");
            $table->integer("good_price");
            $table->integer("good_stock");
            $table->string("picture_path");
            $table->unsignedBigInteger("good_category");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("good_category")->references("id")->on("goods_categories");
            $table->foreign("good_publisher")->references("id")->on("publishers");
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
