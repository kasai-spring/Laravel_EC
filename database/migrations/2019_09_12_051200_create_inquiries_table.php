<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("user_name")->nullable();
            $table->string("email")->nullable();
            $table->string("option");
            $table->string("subject");
            $table->text("content");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
}
