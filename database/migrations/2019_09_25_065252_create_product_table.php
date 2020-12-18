<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->float('weight')->nullable();
            $table->text('dimension')->nullable();
            $table->string('url',255)->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('alert_quantity')->nullable();
            $table->float('sale_price')->nullable();
            $table->float('purchase_price')->default(0);
            $table->float('discount')->nullable();
            $table->timestamp('discount_start_date')->nullable();
            $table->timestamp('discount_end_date')->nullable();
            $table->text('free_items')->nullable();
            $table->timestamp('publish_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('image')->nullable();
            $table->string('colors', 500)->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
