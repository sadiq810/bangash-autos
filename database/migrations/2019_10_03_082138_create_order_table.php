<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->nullable()->comment('0-walking customer, order placed by admin');
            $table->float('total')->nullable();
            $table->float('discount')->nullable();
            $table->float('promo_discount')->nullable();
            $table->float('voucher_discount')->nullable();
            $table->integer('voucher_id')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('shipping_cost')->nullable();
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('process_by')->nullable()->comment('User Id who changed the status');
            $table->bigInteger('completed_by')->nullable()->comment('User Id who changed the status');
            $table->tinyInteger('status')->default(0)->comment('0-pending, 1-process, 2-completed, 3-order returned.');
            $table->tinyInteger('type')->default(0)->comment('0- order from site, 1- placed by admin user or local order fulfilled on the spot');
            $table->text('payload')->nullable();
            $table->string('country')->nullable();
            $table->text('courier')->nullable();
            $table->text('payments')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
