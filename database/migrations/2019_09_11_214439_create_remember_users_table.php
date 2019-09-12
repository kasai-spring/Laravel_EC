<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRememberUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remember_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->string("token");
            $table->string("ip_address")->nullable();
            $table->timestamps();
            $table->timestamp("expired_at")->nullable();

            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remember_users');
    }
}
