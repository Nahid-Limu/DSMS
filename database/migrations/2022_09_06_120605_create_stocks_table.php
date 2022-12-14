<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable()->index();
            $table->integer('group_id')->nullable()->index();
            $table->integer('product_id')->nullable()->index();
            $table->double('stock_size')->nullable();
            $table->integer('stock_piece')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
