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
            $table->integer('company_id')->nullable()->index();
            $table->integer('group_id')->nullable()->index();
            $table->string('product_name')->nullable();
            $table->string('size')->nullable();
            $table->integer('piece')->nullable();
            $table->double('buy_price')->nullable();
            $table->double('sell_price')->nullable();
            $table->tinyInteger('status')->comment('"1" is active or  "0" deactive')->default(1);
            $table->timestamps();
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
