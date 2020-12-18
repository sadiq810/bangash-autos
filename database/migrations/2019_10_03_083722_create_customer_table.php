<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('city_id')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
