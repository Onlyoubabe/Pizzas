<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->after('id');
            $table->foreignId('pizza_id')->after('order_id');
            $table->integer('quantity')->after('pizza_id');
            $table->decimal('price', 10, 2)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'pizza_id', 'quantity', 'price']);
        });
    }
};