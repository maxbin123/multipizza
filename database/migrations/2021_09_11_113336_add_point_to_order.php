<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('code')->after('delivery_id')->nullable();
            $table->string('flat')->after('delivery_id')->nullable();
            $table->integer('floor')->after('delivery_id')->nullable();
            $table->integer('door')->after('delivery_id')->nullable();
            $table->string('address')->after('delivery_id')->nullable();
            $table->double('longitude')->after('delivery_id')->nullable();
            $table->double('latitude')->after('delivery_id')->nullable();
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
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('address');
            $table->dropColumn('door');
            $table->dropColumn('flat');
            $table->dropColumn('floor');
            $table->dropColumn('code');
        });
    }
}
