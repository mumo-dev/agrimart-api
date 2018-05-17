<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger("user_id");
            $table->text('description');
            $table->decimal("price");
            $table->timestamps();
          /*  $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade")->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->unsigned();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
