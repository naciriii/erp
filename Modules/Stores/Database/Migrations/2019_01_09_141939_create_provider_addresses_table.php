<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_primary');
            $table->string('city');
            $table->string('street');
            $table->decimal('lat', 8, 6);
            $table->decimal('lng', 8, 6);
            $table->string('address');
            $table->integer('provider_id');

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
        Schema::dropIfExists('provider_addresses');
    }
}
