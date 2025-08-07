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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id');
            $table->decimal('total', 10, 2)->after('user_id');
            $table->string('status')->after('total');
            $table->string('payment_id')->nullable()->after('status');
            $table->string('address')->after('payment_id');
            $table->string('phone')->after('address');
            $table->text('notes')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'total', 'status', 'payment_id', 'address', 'phone', 'notes']);
        });
    }
};