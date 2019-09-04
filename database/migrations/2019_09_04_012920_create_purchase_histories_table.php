<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("good_id");
            $table->integer("quantity");
            $table->unsignedBigInteger("address_id");
            $table->unsignedBigInteger("transaction_id");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("good_id")->references("id")->on("goods");
            $table->foreign("address_id")->references("id")->on("addresses");
            $table->foreign("transaction_id")->references("id")->on("transactions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_histories');
    }
}
